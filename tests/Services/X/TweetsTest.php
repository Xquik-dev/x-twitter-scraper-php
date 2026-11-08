<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\X\Tweets\TweetCheckRepostResponse;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetEmbedResponse;
use XTwitterScraper\X\Tweets\TweetGetInsightsResponse;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetGetSubtitlesResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetResolveLinksResponse;
use XTwitterScraper\X\Tweets\TweetTranslateResponse;
use XTwitterScraper\XWriteAction;

/**
 * @internal
 */
final class TweetsTest extends TestCase
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
        $result = $this->client->x->tweets->create(
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->x->tweets->create(
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key',
            communityID: '1500000000000000000',
            isNoteTweet: false,
            media: ['https://example.com/video.mp4'],
            replyToTweetID: '1234567890',
            text: 'Just launched our new feature!',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->x->tweets->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $result = $this->client->x->tweets->list(ids: 'ids');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        $result = $this->client->x->tweets->list(ids: 'ids');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->x->tweets->delete(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetDeleteResponse::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        $result = $this->client->x->tweets->delete(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetDeleteResponse::class, $result);
    }

    #[Test]
    public function testGetFavoriters(): void
    {
        $result = $this->client->x->tweets->getFavoriters('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testGetQuotes(): void
    {
        $result = $this->client->x->tweets->getQuotes('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testGetReplies(): void
    {
        $result = $this->client->x->tweets->getReplies('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetGetRepliesResponse::class, $result);
    }

    #[Test]
    public function testGetRetweeters(): void
    {
        $result = $this->client->x->tweets->getRetweeters('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testGetThread(): void
    {
        $result = $this->client->x->tweets->getThread('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testSearch(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->search(q: 'q');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testSearchWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->search(
            q: 'q',
            advancedQuery: 'advancedQuery',
            anyWords: 'anyWords',
            blueVerifiedOnly: true,
            boundingBox: 'boundingBox',
            cardName: 'cardName',
            cashtags: 'cashtags',
            conversationID: 'conversationId',
            cursor: 'cursor',
            exactPhrase: 'exactPhrase',
            excludeSource: 'excludeSource',
            excludeWords: 'excludeWords',
            fromUser: 'fromUser',
            geocode: 'geocode',
            hashtags: 'hashtags',
            inReplyToTweetID: 'inReplyToTweetId',
            language: 'language',
            limit: 1,
            listID: 'listId',
            maxFaves: 0,
            maxID: 'maxId',
            maxQuotes: 0,
            maxReplies: 0,
            maxRetweets: 0,
            mediaType: 'images',
            mentioning: 'mentioning',
            minBookmarks: 0,
            minFaves: 0,
            minQuotes: 0,
            minReplies: 0,
            minRetweets: 0,
            minViews: 0,
            mode: 'standard',
            nativeRetweets: true,
            near: 'near',
            news: true,
            place: 'place',
            placeCountry: 'placeCountry',
            pointRadius: 'pointRadius',
            queryType: 'Latest',
            quotes: 'include',
            quotesOfTweetID: 'quotesOfTweetId',
            replies: 'include',
            retweets: 'include',
            retweetsOfTweetID: 'retweetsOfTweetId',
            safe: true,
            sinceDate: '2019-12-27',
            sinceID: 'sinceId',
            sinceTime: 'sinceTime',
            source: 'source',
            toUser: 'toUser',
            untilDate: '2019-12-27',
            untilTime: 'untilTime',
            url: 'url',
            verifiedOnly: true,
            within: 'within',
            withinTime: 'withinTime',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testListTop(): void
    {
        $result = $this->client->x->tweets->listTop();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets2::class, $result);
    }

    #[Test]
    public function testBookmark(): void
    {
        $result = $this->client->x->tweets->bookmark('id', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XWriteAction::class, $result);
    }

    #[Test]
    public function testUnbookmark(): void
    {
        $result = $this->client->x->tweets->unbookmark('id', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XWriteAction::class, $result);
    }

    #[Test]
    public function testCheckRepost(): void
    {
        $result = $this->client->x->tweets->checkRepost('id', user: 'user');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetCheckRepostResponse::class, $result);
    }

    #[Test]
    public function testGetRetweeterIds(): void
    {
        $result = $this->client->x->tweets->getRetweeterIds('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUserIDs::class, $result);
    }

    #[Test]
    public function testGetHiddenReplies(): void
    {
        $result = $this->client->x->tweets->getHiddenReplies('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets2::class, $result);
    }

    #[Test]
    public function testTranslate(): void
    {
        $result = $this->client->x->tweets->translate('id', language: 'language');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetTranslateResponse::class, $result);
    }

    #[Test]
    public function testGetInsights(): void
    {
        $result = $this->client->x->tweets->getInsights('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetGetInsightsResponse::class, $result);
    }

    #[Test]
    public function testEmbed(): void
    {
        $result = $this->client->x->tweets->embed('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetEmbedResponse::class, $result);
    }

    #[Test]
    public function testGetSubtitles(): void
    {
        $result = $this->client->x->tweets->getSubtitles('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetGetSubtitlesResponse::class, $result);
    }

    #[Test]
    public function testResolveLinks(): void
    {
        $result = $this->client->x->tweets->resolveLinks(urls: 'urls');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetResolveLinksResponse::class, $result);
    }
}
