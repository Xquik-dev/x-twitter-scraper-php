<?php

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse;
use XTwitterScraper\X\Users\UserGetFollowersYouKnowResponse;
use XTwitterScraper\X\Users\UserGetFollowingResponse;
use XTwitterScraper\X\Users\UserGetLikesResponse;
use XTwitterScraper\X\Users\UserGetMediaResponse;
use XTwitterScraper\X\Users\UserGetMentionsResponse;
use XTwitterScraper\X\Users\UserGetSearchResponse;
use XTwitterScraper\X\Users\UserGetTweetsResponse;
use XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse;

/**
 * @internal
 */
#[CoversNothing]
final class UsersTest extends TestCase
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
    public function testRetrieveBatch(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveBatch(ids: 'ids');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetBatchResponse::class, $result);
    }

    #[Test]
    public function testRetrieveBatchWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveBatch(ids: 'ids');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetBatchResponse::class, $result);
    }

    #[Test]
    public function testRetrieveFollowers(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveFollowers('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetFollowersResponse::class, $result);
    }

    #[Test]
    public function testRetrieveFollowersYouKnow(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveFollowersYouKnow('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetFollowersYouKnowResponse::class, $result);
    }

    #[Test]
    public function testRetrieveFollowing(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveFollowing('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetFollowingResponse::class, $result);
    }

    #[Test]
    public function testRetrieveLikes(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveLikes('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetLikesResponse::class, $result);
    }

    #[Test]
    public function testRetrieveMedia(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveMedia('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetMediaResponse::class, $result);
    }

    #[Test]
    public function testRetrieveMentions(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveMentions('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetMentionsResponse::class, $result);
    }

    #[Test]
    public function testRetrieveSearch(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveSearch(q: 'q');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetSearchResponse::class, $result);
    }

    #[Test]
    public function testRetrieveSearchWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveSearch(q: 'q', cursor: 'cursor');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetSearchResponse::class, $result);
    }

    #[Test]
    public function testRetrieveTweets(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveTweets('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetTweetsResponse::class, $result);
    }

    #[Test]
    public function testRetrieveVerifiedFollowers(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveVerifiedFollowers('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetVerifiedFollowersResponse::class, $result);
    }
}
