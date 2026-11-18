<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\BatchUserTweets;
use XTwitterScraper\Client;
use XTwitterScraper\X\Users\UserGetBatchResponse;

/**
 * @internal
 */
final class UnavailableReasonsTest extends TestCase
{
    private const LOOKUP = [
        'users' => [],
        'has_next_page' => false,
        'next_cursor' => '',
        'requested_count' => 3,
        'processed_count' => 3,
        'returned_count' => 0,
        'unavailable_ids' => ['1234567890', '1234567891', '1234567892'],
        'failed_ids' => [],
        'unprocessed_ids' => [],
    ];

    private const REMOVAL = [
        'id' => '42',
        'type' => 'follower.removed',
        'monitorId' => '10',
        'monitorType' => 'account',
        'occurredAt' => '2026-11-17T23:45:00.000Z',
        'data' => ['id' => '2244994945', 'reason' => 'unavailable', 'unavailableReason' => 'suspended'],
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
    public function testABatchUserLookupSplitsTheUnavailableIDsByWhyXShowsNoAccount(): void
    {
        $this->respond(self::LOOKUP + ['not_found_ids' => ['1234567890', '1234567892'], 'suspended_ids' => ['1234567891']]);

        $answer = $this->client->x->users->retrieveBatch('1234567890,1234567891,1234567892');

        $this->assertSame(['1234567890', '1234567892'], $answer->notFoundIDs);
        $this->assertSame(['1234567891'], $answer->suspendedIDs);
    }

    #[Test]
    public function testABatchUserLookupWithoutTheSplitReadsNull(): void
    {
        $this->respond(self::LOOKUP);

        $answer = $this->client->x->users->retrieveBatch('1234567890,1234567891,1234567892');

        $this->assertNull($answer->notFoundIDs);
        $this->assertNull($answer->suspendedIDs);
    }

    #[Test]
    public function testABatchUserLookupStillBuildsFromTheReleasedPositionalArguments(): void
    {
        $answer = UserGetBatchResponse::with('', 1, 1, 0, ['1234567890'], [], []);

        $this->assertSame(['1234567890'], $answer->unavailableIDs);
        $this->assertNull($answer->notFoundIDs);
        $this->assertSame(['1234567890'], $answer->withNotFoundIDs(['1234567890'])->notFoundIDs);
        $this->assertSame([], UserGetBatchResponse::with('', 1, 1, 0, ['1234567890'], [], [], suspendedIDs: [])->suspendedIDs);
    }

    #[Test]
    public function testABatchTweetsReadSplitsTheUnavailableUsersIntoMissingSuspendedAndProtected(): void
    {
        $this->respond([
            'tweets' => [],
            'has_next_page' => false,
            'next_cursor' => '',
            'unavailable_ids' => ['deleted', 'banned', 'locked'],
            'not_found_ids' => ['deleted'],
            'suspended_ids' => ['banned'],
            'protected_ids' => ['locked'],
            'unprocessed_ids' => [],
        ]);

        $answer = $this->client->x->users->retrieveBatchTweets(usernames: 'deleted,banned,locked');

        $this->assertSame(
            [['deleted'], ['banned'], ['locked']],
            [$answer->notFoundIDs, $answer->suspendedIDs, $answer->protectedIDs],
        );
    }

    #[Test]
    public function testABatchTweetsAnswerBuildsWithEachSplit(): void
    {
        $answer = BatchUserTweets::with(
            tweets: [],
            hasNextPage: false,
            nextCursor: '',
            unavailableIDs: ['deleted', 'banned', 'locked'],
            notFoundIDs: ['deleted'],
            suspendedIDs: ['banned'],
            protectedIDs: ['locked'],
            unprocessedIDs: [],
        );

        $this->assertSame(
            [['deleted'], ['banned'], ['locked']],
            [$answer->notFoundIDs, $answer->suspendedIDs, $answer->protectedIDs],
        );
        $this->assertSame([], $answer->withProtectedIDs([])->protectedIDs);
    }

    #[Test]
    public function testAFollowRemovalOfAnUnavailableAccountSaysWhyXShowsNoAccount(): void
    {
        $this->respond(['events' => [self::REMOVAL], 'hasMore' => false]);
        $this->respond(self::REMOVAL);

        $page = $this->client->events->list();
        $event = $this->client->events->retrieve('42');

        $this->assertSame('suspended', $page->events[0]->data['unavailableReason']);
        $this->assertSame('suspended', $event->data['unavailableReason']);
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
