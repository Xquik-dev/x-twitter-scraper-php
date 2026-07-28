<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;

/**
 * @internal
 */
final class ReadmeQuickstartTest extends TestCase
{
    public function testReadmeQuickstartWithFakeTransport(): void
    {
        $transport = new MockClient;
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                '{"has_next_page":false,"next_cursor":"","tweets":[]}',
            ))
        ;
        $transport->setDefaultResponse($response);

        $client = new Client(
            apiKey: 'My API Key',
            requestOptions: ['transporter' => $transport],
        );

        $client->x->tweets->search(q: 'from:elonmusk', limit: 10);

        $requests = $transport->getRequests();
        $this->assertCount(1, $requests);

        parse_str($requests[0]->getUri()->getQuery(), $query);
        $this->assertSame('from:elonmusk', $query['q'] ?? null);
        $this->assertSame('10', $query['limit'] ?? null);
    }
}
