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
use XTwitterScraper\Client;
use XTwitterScraper\X\Media\MediaDownloadParams;

/**
 * @internal
 */
final class PositionalCallsTest extends TestCase
{
    private const POST = '2102882545427714266';

    private const OPTIONS = ['extraHeaders' => ['X-Positional' => 'yes']];

    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'My API Key',
            baseUrl: 'http://127.0.0.1:4010',
            requestOptions: ['transporter' => $this->transporter],
        );
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $this->transporter->setDefaultResponse(
            $factory->createResponse(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('{}'))
        );
    }

    #[Test]
    public function testAMediaDownloadByPositionSendsTheTweetID(): void
    {
        $this->client->x->media->download(self::POST);

        $this->assertSame(['tweetId' => self::POST], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function testDownloadParamsByPositionHoldTheTweetID(): void
    {
        $params = MediaDownloadParams::with(self::POST);

        $this->assertSame(self::POST, $params->tweetID);
        $this->assertNull($params->imageShows);
    }

    #[Test]
    public function testATweetReadByPositionTakesItsRequestOptions(): void
    {
        $this->client->x->tweets->retrieve(self::POST, self::OPTIONS);

        $this->assertStringEndsWith('/x/tweets/'.self::POST, $this->lastRequest()->getUri()->getPath());
        $this->assertSame('', $this->lastRequest()->getUri()->getQuery());
        $this->assertSame('yes', $this->lastRequest()->getHeaderLine('X-Positional'));
    }

    #[Test]
    public function testTrendsByPositionSendTheirCountRegionAndRequestOptions(): void
    {
        $this->client->trends->list(10, 23424977, self::OPTIONS);

        parse_str($this->lastRequest()->getUri()->getQuery(), $query);
        $this->assertSame(['count' => '10', 'woeid' => '23424977'], $query);
        $this->assertSame('yes', $this->lastRequest()->getHeaderLine('X-Positional'));
    }

    #[Test]
    public function testARawListByPositionTakesItsRequestOptions(): void
    {
        $this->client->monitors->raw->list(self::OPTIONS);

        $this->assertSame('', $this->lastRequest()->getUri()->getQuery());
        $this->assertSame('yes', $this->lastRequest()->getHeaderLine('X-Positional'));
    }

    #[Test]
    public function testRawWebhookDeliveriesByPositionTakeTheirRequestOptions(): void
    {
        $this->client->webhooks->raw->listDeliveries('42', self::OPTIONS);

        $this->assertStringEndsWith('/webhooks/42/deliveries', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('', $this->lastRequest()->getUri()->getQuery());
        $this->assertSame('yes', $this->lastRequest()->getHeaderLine('X-Positional'));
    }

    private function lastRequest(): RequestInterface
    {
        $requests = $this->transporter->getRequests();
        $this->assertNotEmpty($requests);

        return $requests[array_key_last($requests)];
    }
}
