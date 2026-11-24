<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\EmbeddedTweet;
use XTwitterScraper\FootballPollRanking;
use XTwitterScraper\FootballScheduleGame;
use XTwitterScraper\SearchTweet;
use XTwitterScraper\SearchTweet2;
use XTwitterScraper\TweetCommunityUnavailable;
use XTwitterScraper\X\Tweets\TweetDetail;

/**
 * @internal
 */
final class CommunityAndPollRanksTest extends TestCase
{
    private const POST = [
        'id' => '1',
        'text' => 'gm',
        'retweetCount' => 0,
        'replyCount' => 0,
        'likeCount' => 0,
        'quoteCount' => 0,
        'viewCount' => 0,
        'bookmarkCount' => 0,
    ];

    private const HIDDEN = ['communityUnavailable' => ['reason' => 'NotFound']];

    private const GAME = [
        'id' => '7',
        'seasonType' => 'regular',
        'week' => 13,
        'startsAt' => '2026-11-28T17:00:00.000Z',
        'status' => 'scheduled',
        'clock' => null,
        'quarter' => null,
        'home' => ['teamId' => '689566294702555136', 'points' => null],
        'away' => ['teamId' => '689566294702555137', 'points' => null],
        'teamIds' => ['689566294702555136', '689566294702555137'],
        'periods' => [],
        'odds' => null,
    ];

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

    #[Test]
    public function testEachPostReadsWhyXShowsNoCommunity(): void
    {
        $this->respond(['tweet' => self::POST + self::HIDDEN + ['quoted_tweet' => self::POST + self::HIDDEN]]);
        $detail = $this->client->x->tweets->retrieve('1')->tweet;
        $this->assertSame('NotFound', $detail->communityUnavailable?->reason);
        $this->assertSame('NotFound', $detail->quotedTweet?->communityUnavailable?->reason);

        $this->respond(['tweets' => [self::POST + self::HIDDEN], 'has_next_page' => false, 'next_cursor' => '']);
        $bookmark = $this->client->x->bookmarks->list()->tweets[0];
        $this->assertInstanceOf(SearchTweet::class, $bookmark);
        $this->assertSame('NotFound', $bookmark->communityUnavailable?->reason);

        $this->respond(['tweets' => [self::POST + self::HIDDEN], 'has_next_page' => false, 'next_cursor' => '']);
        $this->assertSame('NotFound', $this->client->x->tweets->listTop()->tweets[0]->communityUnavailable?->reason);
    }

    #[Test]
    public function testAPostXGivesNoReasonForReadsNull(): void
    {
        $this->respond(['tweet' => self::POST]);

        $this->assertNull($this->client->x->tweets->retrieve('1')->tweet->communityUnavailable);
    }

    #[Test]
    public function testEachPostBuildsWithWhyXShowsNoCommunity(): void
    {
        $reason = TweetCommunityUnavailable::with(reason: 'NotFound');
        $posts = [
            EmbeddedTweet::with(id: '1', bookmarkCount: 0, likeCount: 0, quoteCount: 0, replyCount: 0, retweetCount: 0, text: 'gm', viewCount: 0, communityUnavailable: $reason),
            SearchTweet::with(id: '1', bookmarkCount: 0, likeCount: 0, quoteCount: 0, replyCount: 0, retweetCount: 0, text: 'gm', viewCount: 0, communityUnavailable: $reason),
            SearchTweet2::with(id: '1', text: 'gm', retweetCount: 0, replyCount: 0, likeCount: 0, quoteCount: 0, viewCount: 0, bookmarkCount: 0, communityUnavailable: $reason),
            TweetDetail::with(id: '1', bookmarkCount: 0, likeCount: 0, quoteCount: 0, replyCount: 0, retweetCount: 0, text: 'gm', viewCount: 0, communityUnavailable: $reason),
        ];

        foreach ($posts as $post) {
            $this->assertSame('NotFound', $post->communityUnavailable?->reason);
            $this->assertNull($post->withCommunityUnavailable(null)->communityUnavailable);
            $this->assertSame('Hidden', $post->withCommunityUnavailable(['reason' => 'Hidden'])->communityUnavailable?->reason);
        }

        $this->assertSame('Hidden', $reason->withReason('Hidden')->reason);
    }

    #[Test]
    public function testEachGameReadsItsPollRanks(): void
    {
        $this->respond([
            'league' => 'ncaaf',
            'games' => [
                self::GAME + ['rankings' => [['teamId' => '689566294702555136', 'rank' => 5], ['teamId' => null, 'rank' => null]]],
                self::GAME + ['rankings' => []],
                self::GAME,
            ],
            'teams' => [],
        ]);

        $games = $this->client->x->sports->listGames('ncaaf')->games;

        $this->assertSame('689566294702555136', $games[0]->rankings[0]->teamID ?? null);
        $this->assertSame(5, $games[0]->rankings[0]->rank ?? null);
        $this->assertNull($games[0]->rankings[1]->teamID ?? null);
        $this->assertSame([], $games[1]->rankings);
        $this->assertNull($games[2]->rankings);
    }

    #[Test]
    public function testAGameBuildsWithItsPollRanks(): void
    {
        $ranking = FootballPollRanking::with(teamID: '689566294702555136', rank: 5);
        $game = FootballScheduleGame::with(
            id: '7',
            seasonType: 'regular',
            week: 13,
            startsAt: null,
            status: 'scheduled',
            clock: null,
            quarter: null,
            home: ['teamId' => '689566294702555136', 'points' => null],
            away: ['teamId' => '689566294702555137', 'points' => null],
            teamIDs: ['689566294702555136', '689566294702555137'],
            periods: [],
            odds: null,
            rankings: [$ranking],
        );

        $this->assertSame(5, $game->rankings[0]->rank ?? null);
        $this->assertNull($game->withRankings(null)->rankings);
        $this->assertSame(1, $game->withRankings([['teamId' => '689566294702555137', 'rank' => 1]])->rankings[0]->rank ?? null);
        $this->assertSame('689566294702555137', $ranking->withTeamID('689566294702555137')->teamID);
        $this->assertSame(2, $ranking->withRank(2)->rank);
    }

    /**
     * @param array<string,mixed> $body
     */
    private function respond(array $body): void
    {
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body, JSON_THROW_ON_ERROR));
        $this->transporter->addResponse(
            $factory->createResponse(200)->withHeader('Content-Type', 'application/json')->withBody($stream)
        );
    }
}
