<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X\Users;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Users\Follow\FollowDeleteAllResponse;
use XTwitterScraper\X\Users\Follow\FollowNewResponse;

/**
 * @internal
 */
final class FollowTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(
            apiKey: 'My API Key',
            bearerToken: 'My Bearer Token',
            baseUrl: $testUrl,
        );

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        $result = $this->client->x->users->follow->create(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FollowNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->x->users->follow->create(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FollowNewResponse::class, $result);
    }

    #[Test]
    public function testDeleteAll(): void
    {
        $result = $this->client->x->users->follow->deleteAll(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FollowDeleteAllResponse::class, $result);
    }

    #[Test]
    public function testDeleteAllWithOptionalParams(): void
    {
        $result = $this->client->x->users->follow->deleteAll(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FollowDeleteAllResponse::class, $result);
    }
}
