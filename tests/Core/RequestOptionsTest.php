<?php

declare(strict_types=1);

namespace Tests\Core;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\RequestOptions;

/**
 * @internal
 */
final class RequestOptionsTest extends TestCase
{
    #[Test]
    public function testDefaultsAndFactoryOverrides(): void
    {
        $transport = new MockClient;
        $streaming = new MockClient;
        $uriFactory = Psr17FactoryDiscovery::findUriFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();

        $defaults = new RequestOptions;
        $this->assertSame(60.0, $defaults->timeout);
        $this->assertSame(2, $defaults->maxRetries);
        $this->assertSame(0.5, $defaults->initialRetryDelay);
        $this->assertSame(8.0, $defaults->maxRetryDelay);
        $this->assertFalse($defaults->offsetExists('extraHeaders'));

        $options = RequestOptions::with(
            timeout: 30,
            maxRetries: 4,
            initialRetryDelay: 1,
            maxRetryDelay: 10,
            extraHeaders: ['Header' => 'value'],
            extraQueryParams: ['query' => 'value'],
            extraBodyParams: ['body' => 'value'],
            transporter: $transport,
            streamingTransporter: $streaming,
            uriFactory: $uriFactory,
            streamFactory: $streamFactory,
            requestFactory: $requestFactory,
        );

        $this->assertSame(30.0, $options->timeout);
        $this->assertSame(4, $options->maxRetries);
        $this->assertSame(1.0, $options->initialRetryDelay);
        $this->assertSame(10.0, $options->maxRetryDelay);
        $this->assertSame(['Header' => 'value'], $options->extraHeaders);
        $this->assertSame(['query' => 'value'], $options->extraQueryParams);
        $this->assertSame(['body' => 'value'], $options->extraBodyParams);
        $this->assertSame($transport, $options->transporter);
        $this->assertSame($streaming, $options->streamingTransporter);
        $this->assertSame($uriFactory, $options->uriFactory);
        $this->assertSame($streamFactory, $options->streamFactory);
        $this->assertSame($requestFactory, $options->requestFactory);
    }

    #[Test]
    public function testCloneSettersDoNotMutateTheSource(): void
    {
        $source = new RequestOptions;
        $transport = new MockClient;
        $streaming = new MockClient;
        $uriFactory = Psr17FactoryDiscovery::findUriFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();

        $options = $source
            ->withTimeout(30)
            ->withMaxRetries(4)
            ->withInitialRetryDelay(1)
            ->withMaxRetryDelay(10)
            ->withExtraHeaders(['Header' => 'value'])
            ->withExtraQueryParams(['query' => 'value'])
            ->withExtraBodyParams(['body' => 'value'])
            ->withTransporter($transport)
            ->withStreamingTransporter($streaming)
            ->withUriFactory($uriFactory)
            ->withStreamFactory($streamFactory)
            ->withRequestFactory($requestFactory)
        ;

        $this->assertNotSame($source, $options);
        $this->assertSame(60.0, $source->timeout);
        $this->assertSame(30.0, $options->timeout);
        $this->assertSame(4, $options->maxRetries);
        $this->assertSame(1.0, $options->initialRetryDelay);
        $this->assertSame(10.0, $options->maxRetryDelay);
        $this->assertSame(['Header' => 'value'], $options->extraHeaders);
        $this->assertSame(['query' => 'value'], $options->extraQueryParams);
        $this->assertSame(['body' => 'value'], $options->extraBodyParams);
        $this->assertSame($transport, $options->transporter);
        $this->assertSame($streaming, $options->streamingTransporter);
        $this->assertSame($uriFactory, $options->uriFactory);
        $this->assertSame($streamFactory, $options->streamFactory);
        $this->assertSame($requestFactory, $options->requestFactory);
    }

    #[Test]
    public function testParseMergesArraysInstancesAndNullsInOrder(): void
    {
        $base = RequestOptions::with(
            timeout: 30,
            maxRetries: 3,
            extraHeaders: ['Base' => 'value'],
        );
        $parsed = RequestOptions::parse(
            null,
            $base,
            ['timeout' => 10, 'extraQueryParams' => ['q' => 'value']],
        );

        $this->assertNotSame($base, $parsed);
        $this->assertSame(10.0, $parsed->timeout);
        $this->assertSame(3, $parsed->maxRetries);
        $this->assertSame(['Base' => 'value'], $parsed->extraHeaders);
        $this->assertSame(['q' => 'value'], $parsed->extraQueryParams);
    }
}
