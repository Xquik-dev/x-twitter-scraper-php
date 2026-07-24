<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleGetPerformanceResponse;
use XTwitterScraper\Styles\StyleListResponse;
use XTwitterScraper\Styles\StyleProfile;

/**
 * @internal
 */
final class StylesTest extends TestCase
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
        $result = $this->client->styles->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleProfile::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->styles->update(
            'id',
            label: 'Professional Voice',
            tweets: [['text' => 'Excited to share our latest research findings.']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleProfile::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->styles->update(
            'id',
            label: 'Professional Voice',
            tweets: [['text' => 'Excited to share our latest research findings.']],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleProfile::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $result = $this->client->styles->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        $result = $this->client->styles->delete('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testAnalyze(): void
    {
        $result = $this->client->styles->analyze(username: 'elonmusk');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleProfile::class, $result);
    }

    #[Test]
    public function testAnalyzeWithOptionalParams(): void
    {
        $result = $this->client->styles->analyze(username: 'elonmusk');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleProfile::class, $result);
    }

    #[Test]
    public function testCompare(): void
    {
        $result = $this->client->styles->compare(
            username1: 'username1',
            username2: 'username2'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleCompareResponse::class, $result);
    }

    #[Test]
    public function testCompareWithOptionalParams(): void
    {
        $result = $this->client->styles->compare(
            username1: 'username1',
            username2: 'username2'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleCompareResponse::class, $result);
    }

    #[Test]
    public function testGetPerformance(): void
    {
        $result = $this->client->styles->getPerformance('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleGetPerformanceResponse::class, $result);
    }
}
