<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use XTwitterScraper\ActivityLogRow;
use XTwitterScraper\Client;

/**
 * @internal
 */
final class ApiCatchUpTest extends TestCase
{
    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'My API Key',
            bearerToken: 'My Bearer Token',
            baseUrl: 'http://127.0.0.1:4010',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    #[Test]
    public function testAPathWithTwoValuesFillsBothInOrder(): void
    {
        $this->respond('application/json', '{}');

        $this->client->x->sports->retrieveRoster('nfl', 'game 1');

        $this->assertStringEndsWith('/x/sports/nfl/games/game%201/roster', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function testAListThatTookNoArgumentsSendsItsNewQuery(): void
    {
        $this->respond('application/json', '{}');

        $this->client->monitors->list(limit: 5, cursor: 'next');

        parse_str($this->lastRequest()->getUri()->getQuery(), $query);
        $this->assertSame(['limit' => '5', 'cursor' => 'next'], $query);
    }

    #[Test]
    public function testAnEmptyBulkRetrySendsNoBody(): void
    {
        $this->respond('application/json', '{}');

        $this->client->x->accounts->bulkRetry();

        $this->assertSame('', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function testABulkRetrySendsTheAccountIDsUnderTheirAPIName(): void
    {
        $this->respond('application/json', '{}');

        $this->client->x->accounts->bulkRetry(accountIDs: ['1']);

        $this->assertSame('{"accountIds":["1"]}', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function testANewBodyFieldTravelsBesideTheDryRunQuery(): void
    {
        $this->respond('application/json', '{}');

        $this->client->extractions->run(toolType: 'user_affiliates', dryRun: true, enrichProfiles: true);

        parse_str($this->lastRequest()->getUri()->getQuery(), $query);
        $this->assertSame(['dry_run' => 'true'], $query);
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertIsArray($body);
        $this->assertTrue($body['enrichProfiles']);
        $this->assertArrayNotHasKey('dryRun', $body);
    }

    #[Test]
    public function testAnEventStreamAsksForServerSentEventsAndKeepsTheBodyReadable(): void
    {
        $this->respond('text/event-stream', "event: tweet.new\ndata: {}\n\n");

        $response = $this->client->events->stream();

        $this->assertSame('text/event-stream', $this->lastRequest()->getHeaderLine('Accept'));
        $this->assertStringContainsString('event: tweet.new', (string) $response->getBody());
    }

    #[Test]
    public function testANewListOperationParsesEachRow(): void
    {
        $this->respond('application/json', '[{"id":"1"}]');

        $rows = $this->client->activity->list();

        $this->assertCount(1, $rows);
        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ActivityLogRow::class, $rows[0]);
    }

    private function respond(string $contentType, string $text): void
    {
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream($text);
        $this->transporter->addResponse(
            $factory->createResponse(200)->withHeader('Content-Type', $contentType)->withBody($stream)
        );
    }

    private function lastRequest(): RequestInterface
    {
        $requests = $this->transporter->getRequests();
        $this->assertNotEmpty($requests);

        return $requests[array_key_last($requests)];
    }
}
