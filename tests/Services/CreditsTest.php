<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;

/**
 * @internal
 */
final class CreditsTest extends TestCase
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
    public function testRedirectTopupCheckout(): void
    {
        $result = $this->client->credits->redirectTopupCheckout(
            sessionID: 'session_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testRedirectTopupCheckoutWithOptionalParams(): void
    {
        $result = $this->client->credits->redirectTopupCheckout(
            sessionID: 'session_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testRetrieveBalance(): void
    {
        $result = $this->client->credits->retrieveBalance();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CreditGetBalanceResponse::class, $result);
    }

    #[Test]
    public function testRetrieveTopupStatus(): void
    {
        $result = $this->client->credits->retrieveTopupStatus(
            sessionID: 'session_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CreditGetTopupStatusResponse::class, $result);
    }

    #[Test]
    public function testRetrieveTopupStatusWithOptionalParams(): void
    {
        $result = $this->client->credits->retrieveTopupStatus(
            sessionID: 'session_id'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CreditGetTopupStatusResponse::class, $result);
    }

    #[Test]
    public function testTopupBalance(): void
    {
        $result = $this->client->credits->topupBalance(dollars: 10);

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CreditTopupBalanceResponse::class, $result);
    }

    #[Test]
    public function testTopupBalanceWithOptionalParams(): void
    {
        $result = $this->client->credits->topupBalance(dollars: 10, locale: 'en');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CreditTopupBalanceResponse::class, $result);
    }
}
