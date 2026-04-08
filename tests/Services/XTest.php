<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendsResponse;

/**
 * @internal
 */
#[CoversNothing]
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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->getArticle('tweetId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XGetArticleResponse::class, $result);
    }

    #[Test]
    public function testGetHomeTimeline(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->getHomeTimeline();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testGetNotifications(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->getNotifications();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XGetNotificationsResponse::class, $result);
    }

    #[Test]
    public function testGetTrends(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->getTrends();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XGetTrendsResponse::class, $result);
    }
}
