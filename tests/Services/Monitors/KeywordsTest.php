<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\Monitors;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Keywords\KeywordDeactivateResponse;
use XTwitterScraper\Monitors\Keywords\KeywordGetResponse;
use XTwitterScraper\Monitors\Keywords\KeywordListResponse;
use XTwitterScraper\Monitors\Keywords\KeywordNewResponse;
use XTwitterScraper\Monitors\Keywords\KeywordUpdateResponse;

/**
 * @internal
 */
final class KeywordsTest extends TestCase
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
        $result = $this->client->monitors->keywords->create(
            eventTypes: [EventType::TWEET_NEW],
            query: 'xquik OR "x api"'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(KeywordNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->monitors->keywords->create(
            eventTypes: [EventType::TWEET_NEW],
            query: 'xquik OR "x api"'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(KeywordNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->monitors->keywords->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(KeywordGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->monitors->keywords->update('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(KeywordUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $result = $this->client->monitors->keywords->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(KeywordListResponse::class, $result);
    }

    #[Test]
    public function testDeactivate(): void
    {
        $result = $this->client->monitors->keywords->deactivate('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(KeywordDeactivateResponse::class, $result);
    }
}
