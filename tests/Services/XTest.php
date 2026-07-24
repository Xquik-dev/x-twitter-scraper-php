<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendsResponse;

/**
 * @internal
 */
final class XTest extends TestCase
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
    public function testGetArticle(): void
    {
        $result = $this->client->x->getArticle('tweetId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XGetArticleResponse::class, $result);
    }

    #[Test]
    public function testGetHomeTimeline(): void
    {
        $result = $this->client->x->getHomeTimeline();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testGetNotifications(): void
    {
        $result = $this->client->x->getNotifications();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XGetNotificationsResponse::class, $result);
    }

    #[Test]
    public function testGetTrends(): void
    {
        $result = $this->client->x->getTrends();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XGetTrendsResponse::class, $result);
    }
}
