<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\Support;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
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
        $result = $this->client->support->tickets->create(
            body: 'I am unable to connect my X account. Please help.',
            subject: 'Cannot connect X account',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        $result = $this->client->support->tickets->create(
            body: 'I am unable to connect my X account. Please help.',
            subject: 'Cannot connect X account',
            idempotencyKey: 'Idempotency-Key',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->support->tickets->retrieve(
            'tkt_a1b2c3d4e5f6a1b2c3d4e5f6'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        $result = $this->client->support->tickets->update(
            'tkt_a1b2c3d4e5f6a1b2c3d4e5f6',
            status: 'resolved'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        $result = $this->client->support->tickets->update(
            'tkt_a1b2c3d4e5f6a1b2c3d4e5f6',
            status: 'resolved'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        $result = $this->client->support->tickets->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketListResponse::class, $result);
    }

    #[Test]
    public function testReply(): void
    {
        $result = $this->client->support->tickets->reply(
            'tkt_a1b2c3d4e5f6a1b2c3d4e5f6',
            body: 'Thank you for the update.'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketReplyResponse::class, $result);
    }

    #[Test]
    public function testReplyWithOptionalParams(): void
    {
        $result = $this->client->support->tickets->reply(
            'tkt_a1b2c3d4e5f6a1b2c3d4e5f6',
            body: 'Thank you for the update.',
            idempotencyKey: 'Idempotency-Key',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(TicketReplyResponse::class, $result);
    }
}
