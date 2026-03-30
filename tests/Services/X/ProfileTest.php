<?php

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse;
use XTwitterScraper\X\Profile\ProfileUpdateBannerResponse;
use XTwitterScraper\X\Profile\ProfileUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class ProfileTest extends TestCase
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
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->profile->update(account: 'account');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProfileUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->profile->update(
            account: 'account',
            description: 'description',
            location: 'location',
            name: 'name',
            url: 'url',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProfileUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateAvatar(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->profile->updateAvatar(
            account: 'account',
            file: 'file'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProfileUpdateAvatarResponse::class, $result);
    }

    #[Test]
    public function testUpdateAvatarWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->profile->updateAvatar(
            account: 'account',
            file: 'file'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProfileUpdateAvatarResponse::class, $result);
    }

    #[Test]
    public function testUpdateBanner(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->profile->updateBanner(
            account: 'account',
            file: 'file'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProfileUpdateBannerResponse::class, $result);
    }

    #[Test]
    public function testUpdateBannerWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->profile->updateBanner(
            account: 'account',
            file: 'file'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ProfileUpdateBannerResponse::class, $result);
    }
}
