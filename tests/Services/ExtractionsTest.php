<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Extractions\ExtractionEstimateCostResponse;
use XTwitterScraper\Extractions\ExtractionGetResponse;
use XTwitterScraper\Extractions\ExtractionListResponse;
use XTwitterScraper\Extractions\ExtractionRunResponse;

/**
 * @internal
 */
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
        $result = $this->client->extractions->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $result = $this->client->extractions->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionListResponse::class, $result);
    }

    #[Test]
    public function testEstimateCost(): void
    {
        $result = $this->client->extractions->estimateCost(
            toolType: 'follower_explorer'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionEstimateCostResponse::class, $result);
    }

    #[Test]
    public function testEstimateCostWithOptionalParams(): void
    {
        $result = $this->client->extractions->estimateCost(
            toolType: 'follower_explorer',
            advancedQuery: 'min_faves:100',
            anyWords: 'ChatGPT AI model',
            boundingBox: '-74.1 40.6 -73.9 40.8',
            cashtags: '$TSLA $NVDA',
            conversationID: '1234567890',
            exactPhrase: 'artificial intelligence',
            excludeWords: 'spam',
            fromUser: 'nasa',
            hashtags: '#AI startups',
            inReplyToTweetID: '1234567890',
            language: 'en',
            listID: '1234567890',
            mediaType: 'images',
            mentioning: 'example_user',
            minFaves: 10,
            minQuotes: 2,
            minReplies: 3,
            minRetweets: 5,
            place: '96683cc9126741d1',
            placeCountry: 'US',
            pointRadius: '-73.99 40.73 25mi',
            quotes: 'include',
            quotesOfTweetID: '1234567890',
            replies: 'include',
            resultsLimit: 1000,
            retweets: 'exclude',
            retweetsOfTweetID: '1234567890',
            searchQuery: 'AI trends 2025',
            sinceDate: '2025-01-01',
            targetCommunityID: '1500000000000000000',
            targetListID: '1234567890',
            targetSpaceID: '1vOGwMdBqpwGB',
            targetTweetID: '1234567890',
            targetUsername: 'elonmusk',
            toUser: 'openai',
            untilDate: '2025-12-31',
            url: 'example.com',
            verifiedOnly: false,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionEstimateCostResponse::class, $result);
    }

    #[Test]
    public function testExportResults(): void
    {
        $result = $this->client->extractions->exportResults('id', format: 'csv');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsString($result);
    }

    #[Test]
    public function testExportResultsWithOptionalParams(): void
    {
        $result = $this->client->extractions->exportResults('id', format: 'csv');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsString($result);
    }

    #[Test]
    public function testRun(): void
    {
        $result = $this->client->extractions->run(toolType: 'follower_explorer');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionRunResponse::class, $result);
    }

    #[Test]
    public function testRunWithOptionalParams(): void
    {
        $result = $this->client->extractions->run(
            toolType: 'follower_explorer',
            advancedQuery: 'min_faves:100',
            anyWords: 'ChatGPT AI model',
            boundingBox: '-74.1 40.6 -73.9 40.8',
            cashtags: '$TSLA $NVDA',
            conversationID: '1234567890',
            exactPhrase: 'artificial intelligence',
            excludeWords: 'spam',
            fromUser: 'nasa',
            hashtags: '#AI startups',
            inReplyToTweetID: '1234567890',
            language: 'en',
            listID: '1234567890',
            mediaType: 'images',
            mentioning: 'example_user',
            minFaves: 10,
            minQuotes: 2,
            minReplies: 3,
            minRetweets: 5,
            place: '96683cc9126741d1',
            placeCountry: 'US',
            pointRadius: '-73.99 40.73 25mi',
            quotes: 'include',
            quotesOfTweetID: '1234567890',
            replies: 'include',
            resultsLimit: 1000,
            retweets: 'exclude',
            retweetsOfTweetID: '1234567890',
            searchQuery: 'AI trends 2025',
            sinceDate: '2025-01-01',
            targetCommunityID: '1500000000000000000',
            targetListID: '1234567890',
            targetSpaceID: '1vOGwMdBqpwGB',
            targetTweetID: '1234567890',
            targetUsername: 'elonmusk',
            toUser: 'openai',
            untilDate: '2025-12-31',
            url: 'example.com',
            verifiedOnly: false,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionRunResponse::class, $result);
    }
}
