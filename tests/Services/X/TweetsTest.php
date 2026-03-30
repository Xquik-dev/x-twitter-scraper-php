<?php

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;

/**
 * @internal
 */
#[CoversNothing]
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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->create(
            account: 'account',
            text: 'text'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->create(
            account: 'account',
            text: 'text',
            attachmentURL: 'attachment_url',
            communityID: 'community_id',
            isNoteTweet: true,
            mediaIDs: ['string'],
            replyToTweetID: 'reply_to_tweet_id',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->retrieve('tweetId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->list(ids: 'ids');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testListWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->list(ids: 'ids');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->delete('tweetId', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetDeleteResponse::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->delete('tweetId', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetDeleteResponse::class, $result);
    }

    #[Test]
    public function testGetFavoriters(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->getFavoriters('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testGetQuotes(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->getQuotes('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testGetReplies(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->getReplies('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testGetRetweeters(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->getRetweeters('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testGetThread(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

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
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testSearchWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->tweets->search(
            q: 'q',
            cursor: 'cursor',
            limit: 200,
            queryType: 'Latest',
            sinceTime: 'sinceTime',
            untilTime: 'untilTime',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }
}
