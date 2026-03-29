<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Extractions\ExtractionEstimateCostResponse;
use XTwitterScraper\Extractions\ExtractionGetResponse;
use XTwitterScraper\Extractions\ExtractionListResponse;
use XTwitterScraper\Extractions\ExtractionRunResponse;

/**
 * @internal
 */
#[CoversNothing]
final class ExtractionsTest extends TestCase
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

        $result = $this->client->extractions->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->extractions->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionListResponse::class, $result);
    }

    #[Test]
    public function testEstimateCost(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->extractions->estimateCost(
            toolType: 'article_extractor'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionEstimateCostResponse::class, $result);
    }

    #[Test]
    public function testEstimateCostWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->extractions->estimateCost(
            toolType: 'article_extractor',
            advancedQuery: 'advancedQuery',
            exactPhrase: 'exactPhrase',
            excludeWords: 'excludeWords',
            searchQuery: 'searchQuery',
            targetCommunityID: 'targetCommunityId',
            targetListID: 'targetListId',
            targetSpaceID: 'targetSpaceId',
            targetTweetID: 'targetTweetId',
            targetUsername: 'targetUsername',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionEstimateCostResponse::class, $result);
    }

    #[Test]
    public function testExportResults(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->extractions->exportResults('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsString($result);
    }

    #[Test]
    public function testRun(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->extractions->run(toolType: 'article_extractor');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionRunResponse::class, $result);
    }

    #[Test]
    public function testRunWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->extractions->run(
            toolType: 'article_extractor',
            advancedQuery: 'advancedQuery',
            exactPhrase: 'exactPhrase',
            excludeWords: 'excludeWords',
            searchQuery: 'searchQuery',
            targetCommunityID: 'targetCommunityId',
            targetListID: 'targetListId',
            targetSpaceID: 'targetSpaceId',
            targetTweetID: 'targetTweetId',
            targetUsername: 'targetUsername',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionRunResponse::class, $result);
    }
}
