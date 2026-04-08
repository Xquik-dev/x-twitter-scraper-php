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
use XTwitterScraper\Styles\StyleListResponse;

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
    public function testAnalyze(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->analyze(username: 'elonmusk');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(StyleAnalyzeResponse::class, $result);
    }

    #[Test]
    public function testAnalyzeWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->styles->analyze(username: 'elonmusk');

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
}
