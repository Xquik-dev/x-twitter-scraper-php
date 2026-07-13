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
            additionalContext: 'https://x.com/elonmusk/status/1234567890',
            callToAction: 'Follow for more',
            draft: 'AI is changing everything. Here\'s why.',
            goal: 'engagement',
            hasLink: false,
            hasMedia: false,
            mediaType: 'none',
            styleUsername: 'elonmusk',
            tone: 'professional',
            topic: 'AI trends in 2025',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ComposeNewResponse::class, $result);
    }
}
