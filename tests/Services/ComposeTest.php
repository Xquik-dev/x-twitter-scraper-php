<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Compose\ComposeNewResponse;
use XTwitterScraper\Core\Util;

/**
 * @internal
 */
#[CoversNothing]
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
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->compose->create(step: 'compose');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ComposeNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->compose->create(
            step: 'compose',
            additionalContext: 'additionalContext',
            callToAction: 'callToAction',
            draft: 'draft',
            goal: 'engagement',
            hasLink: true,
            hasMedia: true,
            mediaType: 'photo',
            styleUsername: 'styleUsername',
            tone: 'tone',
            topic: 'topic',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ComposeNewResponse::class, $result);
    }
}
