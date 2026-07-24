<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitResponse;

/**
 * @internal
 */
final class AccountConnectionChallengesTest extends TestCase
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
    public function testSubmit(): void
    {
        $result = $this->client->x->accountConnectionChallenges->submit(
            'id',
            emailCode: '<EMAIL_VERIFICATION_CODE>'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            AccountConnectionChallengeSubmitResponse::class,
            $result
        );
    }

    #[Test]
    public function testSubmitWithOptionalParams(): void
    {
        $result = $this->client->x->accountConnectionChallenges->submit(
            'id',
            emailCode: '<EMAIL_VERIFICATION_CODE>'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            AccountConnectionChallengeSubmitResponse::class,
            $result
        );
    }
}
