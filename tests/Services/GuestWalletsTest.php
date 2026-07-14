<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;
use XTwitterScraper\GuestWallets\GuestWalletNewResponse;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse;

/**
 * @internal
 */
#[CoversNothing]
final class GuestWalletsTest extends TestCase
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

        $result = $this->client->guestWallets->create(
            amountMinor: 1000,
            idempotencyKey: 'e1cb97D8-dDF3-4AaA-ad0a-49E4A0d1CfAa'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GuestWalletNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->guestWallets->create(
            amountMinor: 1000,
            currency: 'usd',
            idempotencyKey: 'e1cb97D8-dDF3-4AaA-ad0a-49E4A0d1CfAa',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GuestWalletNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieveStatus(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->guestWallets->retrieveStatus();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GuestWalletGetStatusResponse::class, $result);
    }

    #[Test]
    public function testTopup(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->guestWallets->topup(
            amountMinor: 1000,
            idempotencyKey: 'e1cb97D8-dDF3-4AaA-ad0a-49E4A0d1CfAa'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GuestWalletTopupResponse::class, $result);
    }

    #[Test]
    public function testTopupWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->guestWallets->topup(
            amountMinor: 1000,
            currency: 'usd',
            idempotencyKey: 'e1cb97D8-dDF3-4AaA-ad0a-49E4A0d1CfAa',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GuestWalletTopupResponse::class, $result);
    }
}
