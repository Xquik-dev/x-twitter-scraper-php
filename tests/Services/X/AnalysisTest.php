<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\TweetAnalysisPage;

/**
 * @internal
 */
final class AnalysisTest extends TestCase
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
    public function testSentiment(): void
    {
        $result = $this->client->x->analysis->sentiment();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetAnalysisPage::class, $result);
    }

    #[Test]
    public function testBrand(): void
    {
        $result = $this->client->x->analysis->brand();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetAnalysisPage::class, $result);
    }

    #[Test]
    public function testNews(): void
    {
        $result = $this->client->x->analysis->news();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetAnalysisPage::class, $result);
    }

    #[Test]
    public function testMarketSignals(): void
    {
        $result = $this->client->x->analysis->marketSignals();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetAnalysisPage::class, $result);
    }

    #[Test]
    public function testViralScore(): void
    {
        $result = $this->client->x->analysis->viralScore();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetAnalysisPage::class, $result);
    }

    #[Test]
    public function testClassify(): void
    {
        $result = $this->client->x->analysis->classify();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TweetAnalysisPage::class, $result);
    }
}
