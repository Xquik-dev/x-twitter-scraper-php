<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\BatchUserTweets;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedLists;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\ShadowbanReport;
use XTwitterScraper\UserLiveStatus;
use XTwitterScraper\UserProfile;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserRemoveFollowerResponse;
use XTwitterScraper\X\Users\UserRetrieveFollowerAuditResponse;
use XTwitterScraper\X\Users\UserRetrieveInsightsResponse;
use XTwitterScraper\X\Users\UserTranslateBioResponse;
use XTwitterScraper\XWriteAction;

/**
 * @internal
 */
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
    public function testRetrieve(): void
    {
        $result = $this->client->x->users->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserProfile::class, $result);
    }

    #[Test]
    public function testRemoveFollower(): void
    {
        $result = $this->client->x->users->removeFollower(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserRemoveFollowerResponse::class, $result);
    }

    #[Test]
    public function testRemoveFollowerWithOptionalParams(): void
    {
        $result = $this->client->x->users->removeFollower(
            'id',
            account: '@elonmusk',
            idempotencyKey: 'Idempotency-Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserRemoveFollowerResponse::class, $result);
    }

    #[Test]
    public function testRetrieveBatch(): void
    {
        $result = $this->client->x->users->retrieveBatch(ids: 'ids');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserGetBatchResponse::class, $result);
    }

    #[Test]
    public function testRetrieveBatchWithOptionalParams(): void
    {
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
        $this->assertNotNull($result);
    }

    #[Test]
    public function testRetrieveFollowersYouKnow(): void
    {
        $result = $this->client->x->users->retrieveFollowersYouKnow('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testRetrieveFollowing(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveFollowing('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testRetrieveLikes(): void
    {
        $result = $this->client->x->users->retrieveLikes('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testRetrieveMedia(): void
    {
        $result = $this->client->x->users->retrieveMedia('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testRetrieveMentions(): void
    {
        $result = $this->client->x->users->retrieveMentions('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testRetrieveReplies(): void
    {
        $result = $this->client->x->users->retrieveReplies('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testRetrieveSearch(): void
    {
        $result = $this->client->x->users->retrieveSearch(q: 'q');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testRetrieveSearchWithOptionalParams(): void
    {
        $result = $this->client->x->users->retrieveSearch(
            q: 'q',
            bioContains: 'bioContains',
            cursor: 'cursor',
            hasLocation: true,
            hasWebsite: true,
            locationContains: 'locationContains',
            maxFollowers: 0,
            maxFollowing: 0,
            maxStatuses: 0,
            minAccountAgeDays: 0,
            minFollowers: 0,
            minFollowing: 0,
            minStatuses: 0,
            usernameContains: 'usernameContains',
            verifiedOnly: true,
            verifiedType: 'verifiedType',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testRetrieveTweets(): void
    {
        $result = $this->client->x->users->retrieveTweets('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testRetrieveVerifiedFollowers(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->users->retrieveVerifiedFollowers('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testRetrieveBatchTweets(): void
    {
        $result = $this->client->x->users->retrieveBatchTweets();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BatchUserTweets::class, $result);
    }

    #[Test]
    public function testBlock(): void
    {
        $result = $this->client->x->users->block('id', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XWriteAction::class, $result);
    }

    #[Test]
    public function testUnblock(): void
    {
        $result = $this->client->x->users->unblock('id', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XWriteAction::class, $result);
    }

    #[Test]
    public function testMute(): void
    {
        $result = $this->client->x->users->mute('id', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XWriteAction::class, $result);
    }

    #[Test]
    public function testUnmute(): void
    {
        $result = $this->client->x->users->unmute('id', account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XWriteAction::class, $result);
    }

    #[Test]
    public function testRetrieveAffiliates(): void
    {
        $result = $this->client->x->users->retrieveAffiliates('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testRetrieveSubscriptions(): void
    {
        $result = $this->client->x->users->retrieveSubscriptions('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testRetrieveLists(): void
    {
        $result = $this->client->x->users->retrieveLists('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedLists::class, $result);
    }

    #[Test]
    public function testRetrieveListMemberships(): void
    {
        $result = $this->client->x->users->retrieveListMemberships('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedLists::class, $result);
    }

    #[Test]
    public function testRetrieveArticles(): void
    {
        $result = $this->client->x->users->retrieveArticles('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets2::class, $result);
    }

    #[Test]
    public function testRetrieveHighlights(): void
    {
        $result = $this->client->x->users->retrieveHighlights('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets2::class, $result);
    }

    #[Test]
    public function testRetrieveSimilar(): void
    {
        $result = $this->client->x->users->retrieveSimilar('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testTranslateBio(): void
    {
        $result = $this->client->x->users->translateBio('id', language: 'language');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserTranslateBioResponse::class, $result);
    }

    #[Test]
    public function testRetrieveFollowerAudit(): void
    {
        $result = $this->client->x->users->retrieveFollowerAudit('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserRetrieveFollowerAuditResponse::class, $result);
    }

    #[Test]
    public function testRetrieveInsights(): void
    {
        $result = $this->client->x->users->retrieveInsights('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserRetrieveInsightsResponse::class, $result);
    }

    #[Test]
    public function testRetrieveLive(): void
    {
        $result = $this->client->x->users->retrieveLive('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(UserLiveStatus::class, $result);
    }

    #[Test]
    public function testRetrieveShadowban(): void
    {
        $result = $this->client->x->users->retrieveShadowban('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ShadowbanReport::class, $result);
    }

    #[Test]
    public function testRetrieveFollowerIds(): void
    {
        $result = $this->client->x->users->retrieveFollowerIds('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUserIDs::class, $result);
    }

    #[Test]
    public function testRetrieveFollowingIds(): void
    {
        $result = $this->client->x->users->retrieveFollowingIds('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUserIDs::class, $result);
    }
}
