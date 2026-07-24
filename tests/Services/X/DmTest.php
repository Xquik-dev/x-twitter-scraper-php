<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Dm\DmGetHistoryResponse;
use XTwitterScraper\X\Dm\DmSendResponse;

/**
 * @internal
 */
final class DmTest extends TestCase
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
    public function testRetrieveHistory(): void
    {
        $result = $this->client->x->dm->retrieveHistory(
            'userId',
            account: 'account'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DmGetHistoryResponse::class, $result);
    }

    #[Test]
    public function testRetrieveHistoryWithOptionalParams(): void
    {
        $result = $this->client->x->dm->retrieveHistory(
            'userId',
            account: 'account',
            cursor: 'cursor',
            maxID: 'maxId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DmGetHistoryResponse::class, $result);
    }

    #[Test]
    public function testSend(): void
    {
        $result = $this->client->x->dm->send(
            'userId',
            account: '@elonmusk',
            text: 'Example text content',
            idempotencyKey: 'Idempotency-Key',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DmSendResponse::class, $result);
    }

    #[Test]
    public function testSendWithOptionalParams(): void
    {
        $result = $this->client->x->dm->send(
            'userId',
            account: '@elonmusk',
            text: 'Example text content',
            idempotencyKey: 'Idempotency-Key',
            mediaIDs: ['1234567890123456789'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DmSendResponse::class, $result);
    }
}
