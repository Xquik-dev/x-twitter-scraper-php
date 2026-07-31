<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Accounts\AccountBulkRetryResponse;
use XTwitterScraper\X\Accounts\AccountDeleteResponse;
use XTwitterScraper\X\Accounts\AccountListResponse;
use XTwitterScraper\X\Accounts\AccountReauthResponse;
use XTwitterScraper\X\Accounts\XAccountDetail;

/**
 * @internal
 */
final class AccountsTest extends TestCase
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
        $result = $this->client->x->accounts->create(
            email: 'account@example.invalid',
            password: '<ACCOUNT_PASSWORD>',
            totpSecret: '<TOTP_SECRET>',
            username: 'your_x_username',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->x->accounts->create(
            email: 'account@example.invalid',
            password: '<ACCOUNT_PASSWORD>',
            totpSecret: '<TOTP_SECRET>',
            username: 'your_x_username',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->x->accounts->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(XAccountDetail::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $result = $this->client->x->accounts->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AccountListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->x->accounts->delete('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AccountDeleteResponse::class, $result);
    }

    #[Test]
    public function testBulkRetry(): void
    {
        $result = $this->client->x->accounts->bulkRetry();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AccountBulkRetryResponse::class, $result);
    }

    #[Test]
    public function testReauth(): void
    {
        $result = $this->client->x->accounts->reauth(
            'id',
            password: '<ACCOUNT_PASSWORD>'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AccountReauthResponse::class, $result);
    }

    #[Test]
    public function testReauthWithOptionalParams(): void
    {
        $result = $this->client->x->accounts->reauth(
            'id',
            password: '<ACCOUNT_PASSWORD>',
            email: 'account@example.invalid',
            totpSecret: '<TOTP_SECRET>',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AccountReauthResponse::class, $result);
    }
}
