<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\Monitors;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Monitors\Posts\PostDeleteResponse;
use XTwitterScraper\Monitors\Posts\PostListResponse;
use XTwitterScraper\PostMonitor;
use XTwitterScraper\PostMonitorMetrics;

/**
 * @internal
 */
final class PostsTest extends TestCase
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
    public function testList(): void
    {
        $result = $this->client->monitors->posts->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PostListResponse::class, $result);
    }

    #[Test]
    public function testCreate(): void
    {
        $result = $this->client->monitors->posts->create(post: 'post');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PostMonitor::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->monitors->posts->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PostMonitor::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->monitors->posts->delete('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PostDeleteResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->monitors->posts->update('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PostMonitor::class, $result);
    }

    #[Test]
    public function testRetrieveMetrics(): void
    {
        $result = $this->client->monitors->posts->retrieveMetrics('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PostMonitorMetrics::class, $result);
    }
}
