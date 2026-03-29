<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Draws\DrawGetResponse;
use XTwitterScraper\Draws\DrawListResponse;
use XTwitterScraper\Draws\DrawRunResponse;

/**
 * @internal
 */
#[CoversNothing]
final class DrawsTest extends TestCase
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
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->draws->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DrawGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->draws->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DrawListResponse::class, $result);
    }

    #[Test]
    public function testExport(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->draws->export('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsString($result);
    }

    #[Test]
    public function testRun(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->draws->run(tweetURL: 'https://example.com');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DrawRunResponse::class, $result);
    }

    #[Test]
    public function testRunWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->draws->run(
            tweetURL: 'https://example.com',
            backupCount: 0,
            filterAccountAgeDays: 0,
            filterLanguage: 'filterLanguage',
            filterMinFollowers: 0,
            mustFollowUsername: 'mustFollowUsername',
            mustRetweet: true,
            requiredHashtags: ['string'],
            requiredKeywords: ['string'],
            requiredMentions: ['string'],
            uniqueAuthorsOnly: true,
            winnerCount: 0,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DrawRunResponse::class, $result);
    }
}
