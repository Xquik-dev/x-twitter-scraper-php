<?php

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Dm\DmGetHistoryResponse;
use XTwitterScraper\X\Dm\DmSendResponse;

/**
 * @internal
 */
#[CoversNothing]
final class DmTest extends TestCase
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
    public function testRetrieveHistory(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->dm->retrieveHistory('userId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DmGetHistoryResponse::class, $result);
    }

    #[Test]
    public function testSend(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->dm->send(
            'userId',
            account: 'account',
            text: 'text'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DmSendResponse::class, $result);
    }

    #[Test]
    public function testSendWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->x->dm->send(
            'userId',
            account: 'account',
            text: 'text',
            mediaIDs: ['string'],
            replyToMessageID: 'reply_to_message_id',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(DmSendResponse::class, $result);
    }
}
