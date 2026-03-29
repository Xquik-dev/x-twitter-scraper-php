<?php

namespace Tests\Services\Support;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Support\Tickets\TicketGetResponse;
use XTwitterScraper\Support\Tickets\TicketListResponse;
use XTwitterScraper\Support\Tickets\TicketNewResponse;
use XTwitterScraper\Support\Tickets\TicketReplyResponse;
use XTwitterScraper\Support\Tickets\TicketUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class TicketsTest extends TestCase
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

        $result = $this->client->support->tickets->create(
            body: 'body',
            subject: 'subject'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->support->tickets->create(
            body: 'body',
            subject: 'subject'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->support->tickets->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->support->tickets->update('id', status: 'open');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->support->tickets->update('id', status: 'open');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->support->tickets->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketListResponse::class, $result);
    }

    #[Test]
    public function testReply(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->support->tickets->reply('id', body: 'body');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketReplyResponse::class, $result);
    }

    #[Test]
    public function testReplyWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->support->tickets->reply('id', body: 'body');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketReplyResponse::class, $result);
    }
}
