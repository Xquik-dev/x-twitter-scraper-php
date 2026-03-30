<?php

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaUploadResponse;

/**
 * @internal
 */
#[CoversNothing]
final class MediaTest extends TestCase
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
    public function testDownload(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->media->download();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MediaDownloadResponse::class, $result);
    }

    #[Test]
    public function testUpload(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->media->upload(account: 'account', file: 'file');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MediaUploadResponse::class, $result);
    }

    #[Test]
    public function testUploadWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->media->upload(
            account: 'account',
            file: 'file',
            isLongVideo: true
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(MediaUploadResponse::class, $result);
    }
}
