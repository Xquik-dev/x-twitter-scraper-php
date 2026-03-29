<?php

namespace Tests\Services\Bot;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkLookupResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkNewResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;

/**
 * @internal
 */
#[CoversNothing]
final class PlatformLinksTest extends TestCase
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

        $result = $this->client->bot->platformLinks->create(
            platform: 'telegram',
            platformUserID: 'platformUserId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PlatformLinkNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->bot->platformLinks->create(
            platform: 'telegram',
            platformUserID: 'platformUserId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PlatformLinkNewResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->bot->platformLinks->delete(
            platform: 'telegram',
            platformUserID: 'platformUserId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PlatformLinkDeleteResponse::class, $result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->bot->platformLinks->delete(
            platform: 'telegram',
            platformUserID: 'platformUserId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PlatformLinkDeleteResponse::class, $result);
    }

    #[Test]
    public function testLookup(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->bot->platformLinks->lookup(
            platform: 'platform',
            platformUserID: 'platformUserId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PlatformLinkLookupResponse::class, $result);
    }

    #[Test]
    public function testLookupWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->bot->platformLinks->lookup(
            platform: 'platform',
            platformUserID: 'platformUserId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PlatformLinkLookupResponse::class, $result);
    }
}
