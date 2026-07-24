<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests\Core;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Core\Implementation\StreamingHttpClient;

/**
 * @internal
 */
final class StreamingHttpClientTest extends TestCase
{
    #[Test]
    public function testDelegatesToGenericPsr18Client(): void
    {
        $inner = new MockClient;
        $inner->setDefaultResponse(Psr17FactoryDiscovery::findResponseFactory()->createResponse(201));
        $client = new StreamingHttpClient($inner);
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test')
        ;

        $this->assertSame(201, $client->sendRequest($request)->getStatusCode());
        $this->assertSame([$request], $inner->getRequests());
    }

    #[Test]
    public function testEnablesStreamingForGuzzleClient(): void
    {
        $handler = new MockHandler([
            Psr17FactoryDiscovery::findResponseFactory()->createResponse(202),
        ]);
        $guzzle = new GuzzleClient(['handler' => $handler]);
        $client = new StreamingHttpClient($guzzle);
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test')
        ;

        $this->assertSame(202, $client->sendRequest($request)->getStatusCode());
        $this->assertCount(0, $handler);
    }
}
