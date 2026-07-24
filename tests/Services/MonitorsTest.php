<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Monitor;
use XTwitterScraper\Monitors\MonitorDeactivateResponse;
use XTwitterScraper\Monitors\MonitorListResponse;
use XTwitterScraper\Monitors\MonitorNewResponse;

/**
 * @internal
 */
final class MonitorsTest extends TestCase
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
        $result = $this->client->monitors->create(
            eventTypes: [EventType::TWEET_NEW, EventType::TWEET_REPLY],
            username: 'elonmusk',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MonitorNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->monitors->create(
            eventTypes: [EventType::TWEET_NEW, EventType::TWEET_REPLY],
            username: 'elonmusk',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MonitorNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->monitors->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Monitor::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->monitors->update('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Monitor::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $result = $this->client->monitors->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MonitorListResponse::class, $result);
    }

    #[Test]
    public function testDeactivate(): void
    {
        $result = $this->client->monitors->deactivate('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MonitorDeactivateResponse::class, $result);
    }
}
