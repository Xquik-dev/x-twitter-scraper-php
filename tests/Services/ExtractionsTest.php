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
            bioContains: 'bioContains',
            blueVerifiedOnly: true,
            boundingBox: '-74.1 40.6 -73.9 40.8',
            cardName: 'cardName',
            cashtags: '$TSLA $NVDA',
            collectionStrategy: 'auto',
            conversationID: '1234567890',
            dedupeAcrossTargets: true,
            dedupeMode: 'none',
            exactPhrase: 'artificial intelligence',
            excludeOriginalAuthor: true,
            excludeSource: 'excludeSource',
            excludeWords: 'spam',
            fromUser: 'nasa',
            geocode: 'geocode',
            hashtags: '#AI startups',
            hasLocation: true,
            hasMediaOnly: true,
            hasWebsite: true,
            includeOriginalPost: true,
            includeSearchTerms: true,
            includeTargetMetadata: true,
            inReplyToTweetID: '1234567890',
            language: 'en',
            listID: '1234567890',
            locationContains: 'locationContains',
            maxDepth: 1,
            maxFollowers: 0,
            maxFollowing: 0,
            maxID: 'maxId',
            maxItemsPerTarget: 1,
            maxLikes: 0,
            maxPagesPerTarget: 1,
            maxPosts: 0,
            maxQuotes: 0,
            maxReplies: 0,
            maxRetweets: 0,
            mediaType: 'images',
            mentioning: 'example_user',
            minAccountAgeDays: 0,
            minBookmarks: 0,
            minFaves: 10,
            minFollowers: 0,
            minFollowing: 0,
            minPosts: 0,
            minQuotes: 2,
            minReplies: 3,
            minRetweets: 5,
            minViews: 0,
            nativeRetweets: true,
            near: 'near',
            news: true,
            overlapMode: true,
            place: '96683cc9126741d1',
            placeCountry: 'US',
            pointRadius: '-73.99 40.73 25mi',
            queryType: 'Latest',
            quotes: 'include',
            quotesOfTweetID: '1234567890',
            relationTargets: [['relation' => 'community_members', 'value' => 'x']],
            replies: 'include',
            resultsLimit: 1000,
            retweets: 'exclude',
            retweetsOfTweetID: '1234567890',
            safe: true,
            scope: 'all',
            searchQueries: ['string'],
            searchQuery: 'AI trends 2025',
            sinceDate: '2025-01-01',
            sinceID: 'sinceId',
            sinceTime: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            sort: 'relevance',
            source: 'source',
            startCursor: 'x',
            targetCommunityID: '1500000000000000000',
            targetCommunityIDs: ['string'],
            targetListID: '1234567890',
            targetListIDs: ['string'],
            targets: ['string'],
            targetSpaceID: '1vOGwMdBqpwGB',
            targetTweetID: '1234567890',
            targetTweetIDs: ['string'],
            targetUsername: 'elonmusk',
            targetUsernames: ['string'],
            toUser: 'openai',
            untilDate: '2025-12-31',
            untilTime: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            url: 'example.com',
            usernameContains: 'usernameContains',
            verifiedOnly: false,
            verifiedType: 'verifiedType',
            within: 'within',
            withinTime: 'withinTime',
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
        $result = $this->client->extractions->exportResults(
            'id',
            format: 'csv',
            hasDescription: true,
            hasLocation: true,
            hasMedia: true,
            lang: 'lang',
            maxFollowers: 0,
            maxFollowing: 0,
            maxPosts: 0,
            minFollowers: 0,
            minFollowing: 0,
            minLikes: 0,
            minPosts: 0,
            minReplies: 0,
            minRetweets: 0,
            minViews: 0,
            search: 'search',
            sinceDate: '2019-12-27',
            untilDate: '2019-12-27',
            verified: true,
        );

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
            dryRun: true,
            advancedQuery: 'min_faves:100',
            anyWords: 'ChatGPT AI model',
            bioContains: 'bioContains',
            blueVerifiedOnly: true,
            boundingBox: '-74.1 40.6 -73.9 40.8',
            cardName: 'cardName',
            cashtags: '$TSLA $NVDA',
            collectionStrategy: 'auto',
            conversationID: '1234567890',
            dedupeAcrossTargets: true,
            dedupeMode: 'none',
            exactPhrase: 'artificial intelligence',
            excludeOriginalAuthor: true,
            excludeSource: 'excludeSource',
            excludeWords: 'spam',
            fromUser: 'nasa',
            geocode: 'geocode',
            hashtags: '#AI startups',
            hasLocation: true,
            hasMediaOnly: true,
            hasWebsite: true,
            includeOriginalPost: true,
            includeSearchTerms: true,
            includeTargetMetadata: true,
            inReplyToTweetID: '1234567890',
            language: 'en',
            listID: '1234567890',
            locationContains: 'locationContains',
            maxDepth: 1,
            maxFollowers: 0,
            maxFollowing: 0,
            maxID: 'maxId',
            maxItemsPerTarget: 1,
            maxLikes: 0,
            maxPagesPerTarget: 1,
            maxPosts: 0,
            maxQuotes: 0,
            maxReplies: 0,
            maxRetweets: 0,
            mediaType: 'images',
            mentioning: 'example_user',
            minAccountAgeDays: 0,
            minBookmarks: 0,
            minFaves: 10,
            minFollowers: 0,
            minFollowing: 0,
            minPosts: 0,
            minQuotes: 2,
            minReplies: 3,
            minRetweets: 5,
            minViews: 0,
            nativeRetweets: true,
            near: 'near',
            news: true,
            overlapMode: true,
            place: '96683cc9126741d1',
            placeCountry: 'US',
            pointRadius: '-73.99 40.73 25mi',
            queryType: 'Latest',
            quotes: 'include',
            quotesOfTweetID: '1234567890',
            relationTargets: [['relation' => 'community_members', 'value' => 'x']],
            replies: 'include',
            resultsLimit: 1000,
            retweets: 'exclude',
            retweetsOfTweetID: '1234567890',
            safe: true,
            scope: 'all',
            searchQueries: ['string'],
            searchQuery: 'AI trends 2025',
            sinceDate: '2025-01-01',
            sinceID: 'sinceId',
            sinceTime: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            sort: 'relevance',
            source: 'source',
            startCursor: 'x',
            targetCommunityID: '1500000000000000000',
            targetCommunityIDs: ['string'],
            targetListID: '1234567890',
            targetListIDs: ['string'],
            targets: ['string'],
            targetSpaceID: '1vOGwMdBqpwGB',
            targetTweetID: '1234567890',
            targetTweetIDs: ['string'],
            targetUsername: 'elonmusk',
            targetUsernames: ['string'],
            toUser: 'openai',
            untilDate: '2025-12-31',
            untilTime: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            url: 'example.com',
            usernameContains: 'usernameContains',
            verifiedOnly: false,
            verifiedType: 'verifiedType',
            within: 'within',
            withinTime: 'withinTime',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ExtractionRunResponse::class, $result);
    }
}
