<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;

/**
 * @internal
 */
final class ComposeTest extends TestCase
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
        $result = $this->client->compose->create(
            topic: 'x',
            goal: 'engagement',
            tone: 'professional',
            draft: 'x'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->compose->create(
            step: 'score',
            topic: 'x',
            goal: 'engagement',
            styleUsername: 'x',
            tone: 'professional',
            additionalContext: 'x',
            callToAction: 'x',
            mediaType: 'photo',
            draft: 'x',
            hasLink: true,
            hasMedia: true,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNotNull($result);
    }
}
