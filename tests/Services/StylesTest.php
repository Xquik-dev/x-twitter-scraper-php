<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Styles\StyleAnalyzeResponse;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleGetPerformanceResponse;
use XTwitterScraper\Styles\StyleGetResponse;
use XTwitterScraper\Styles\StyleListResponse;
use XTwitterScraper\Styles\StyleUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->retrieve('username');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->update(
            'username',
            label: 'label',
            tweets: [['text' => 'text']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->update(
            'username',
            label: 'label',
            tweets: [['text' => 'text']]
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleListResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->delete('username');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testAnalyze(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->analyze(username: 'username');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleAnalyzeResponse::class, $result);
    }

    #[Test]
    public function testAnalyzeWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->analyze(username: 'username');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleAnalyzeResponse::class, $result);
    }

    #[Test]
    public function testCompare(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->getPerformance('username');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleGetPerformanceResponse::class, $result);
    }
}
