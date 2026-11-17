<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\CoverageEndReason;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\SportsGamePosts;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;

/**
 * @internal
 */
final class EndReasonTest extends TestCase
{
    private const TWEETS = ['tweets' => [], 'has_next_page' => false, 'next_cursor' => ''];

    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'My API Key',
            baseUrl: 'http://127.0.0.1:4010',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    /**
     * @param array<string,mixed> $page
     * @param \Closure(Client): (PaginatedTweets|PaginatedTweets2|PaginatedUsers|SportsGamePosts|TweetGetRepliesResponse) $read
     */
    #[Test]
    #[DataProvider('pages')]
    public function testAPageXCutShortReadsStalled(array $page, \Closure $read): void
    {
        $this->respond($page + ['endReason' => 'stalled']);

        $this->assertSame(CoverageEndReason::STALLED->value, $read($this->client)->endReason);
    }

    /**
     * @param array<string,mixed> $page
     * @param \Closure(Client): (PaginatedTweets|PaginatedTweets2|PaginatedUsers|SportsGamePosts|TweetGetRepliesResponse) $read
     */
    #[Test]
    #[DataProvider('pages')]
    public function testAFullPageHasNoEndReason(array $page, \Closure $read): void
    {
        $this->respond($page);

        $this->assertNull($read($this->client)->endReason);
    }

    /**
     * @return array<string, array{array<string,mixed>, \Closure(Client): (PaginatedTweets|PaginatedTweets2|PaginatedUsers|SportsGamePosts|TweetGetRepliesResponse)}>
     */
    public static function pages(): array
    {
        return [
            'bookmarks' => [self::TWEETS, static fn (Client $client): PaginatedTweets => $client->x->bookmarks->list()],
            'top posts' => [self::TWEETS, static fn (Client $client): PaginatedTweets2 => $client->x->tweets->listTop()],
            'community members' => [
                ['users' => [], 'has_next_page' => false, 'next_cursor' => ''],
                static fn (Client $client): PaginatedUsers => $client->x->communities->retrieveMembers('1'),
            ],
            'game posts' => [
                self::TWEETS + ['query' => null],
                static fn (Client $client): SportsGamePosts => $client->x->sports->listPosts('nfl', '1'),
            ],
            'replies' => [self::TWEETS, static fn (Client $client): TweetGetRepliesResponse => $client->x->tweets->getReplies('1')],
        ];
    }

    #[Test]
    public function testEachPageBuildsWithAnEndReason(): void
    {
        $pages = [
            PaginatedTweets::with(tweets: [], hasNextPage: false, nextCursor: '', endReason: CoverageEndReason::STALLED),
            PaginatedTweets2::with(tweets: [], hasNextPage: false, nextCursor: '', endReason: 'stalled'),
            PaginatedUsers::with(hasNextPage: false, nextCursor: '', users: [], endReason: CoverageEndReason::STALLED),
            SportsGamePosts::with(tweets: [], hasNextPage: false, nextCursor: '', query: null, endReason: 'stalled'),
            TweetGetRepliesResponse::with(hasNextPage: false, nextCursor: '', tweets: [], endReason: 'stalled'),
        ];

        foreach ($pages as $page) {
            $this->assertSame('stalled', $page->endReason);
            $this->assertNull($page->withEndReason(null)->endReason);
            $this->assertSame('stalled', $page->withEndReason(CoverageEndReason::STALLED)->endReason);
        }
    }

    /**
     * @param array<string,mixed> $page
     */
    private function respond(array $page): void
    {
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($page, JSON_THROW_ON_ERROR));
        $this->transporter->addResponse(
            $factory->createResponse(200)->withHeader('Content-Type', 'application/json')->withBody($stream)
        );
    }
}
