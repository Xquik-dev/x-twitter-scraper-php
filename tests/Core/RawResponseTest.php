<?php

declare(strict_types=1);

namespace Tests\Core;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use XTwitterScraper\Core\BaseClient;
use XTwitterScraper\Core\Contracts\BasePage;
use XTwitterScraper\Core\Contracts\BaseStream;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\Core\Implementation\RawResponse;
use XTwitterScraper\RequestOptions;

/**
 * @implements BaseStream<mixed>
 */
final class RawTestStream implements BaseStream
{
    public bool $closed = false;

    public function __construct(
        public Converter|ConverterSource|string $convert,
        public RequestInterface $request,
        public ResponseInterface $response,
        public mixed $parsedBody,
    ) {}

    public function close(): void
    {
        $this->closed = true;
    }

    /**
     * @return \Traversable<int,mixed>
     */
    public function getIterator(): \Traversable
    {
        yield $this->parsedBody;
    }
}

/**
 * @implements BasePage<mixed>
 */
final class RawTestPage implements BasePage
{
    /**
     * @param array<string,mixed> $requestInfo
     */
    public function __construct(
        public Converter|ConverterSource|string $convert,
        public BaseClient $client,
        public array $requestInfo,
        public RequestOptions $options,
        public ResponseInterface $response,
        public mixed $parsedBody,
    ) {}

    public function hasNextPage(): bool
    {
        return false;
    }

    /**
     * @return list<mixed>
     */
    public function getItems(): array
    {
        return is_array($this->parsedBody) ? array_values($this->parsedBody) : [];
    }

    public function getNextPage(): static
    {
        throw new \RuntimeException('No next page.');
    }

    /**
     * @return \Generator<mixed>
     */
    public function pagingEachItem(): \Generator
    {
        foreach ($this->getItems() as $item) {
            yield $item;
        }
    }

    /**
     * @return \Traversable<int,static>
     */
    public function getIterator(): \Traversable
    {
        yield $this;
    }
}

final class RawResponseClient extends BaseClient {}

/**
 * @internal
 */
final class RawResponseTest extends TestCase
{
    #[Test]
    public function testParseUnwrapsConvertsAndCachesJsonBody(): void
    {
        $raw = $this->raw(
            '{"payload":{"count":"12"}}',
            unwrap: ['payload', 'count'],
            convert: 'int',
        );

        $this->assertSame(12, $raw->parse());
        $this->assertSame(12, $raw->parse());
        $this->assertSame('https://example.test/items', (string) $raw->getRequest()->getUri());
    }

    #[Test]
    public function testParseBuildsConfiguredStreamAndPageTypes(): void
    {
        $stream = $this->raw(
            '{"items":[1,2]}',
            convert: 'mixed',
            stream: RawTestStream::class,
        )->parse();
        $this->assertInstanceOf(RawTestStream::class, $stream);
        $this->assertSame(['items' => [1, 2]], $stream->parsedBody);
        $this->assertSame([['items' => [1, 2]]], iterator_to_array($stream, preserve_keys: false));
        $stream->close();
        $this->assertTrue($stream->closed);

        $page = $this->raw(
            '{"items":[1,2]}',
            unwrap: 'items',
            convert: 'mixed',
            page: RawTestPage::class,
        )->parse();
        $this->assertInstanceOf(RawTestPage::class, $page);
        $this->assertSame([1, 2], $page->parsedBody);
        $this->assertSame([1, 2], $page->getItems());
        $this->assertFalse($page->hasNextPage());
    }

    #[Test]
    public function testResponseProxyDelegatesEveryPsrResponseOperationImmutably(): void
    {
        $raw = $this->raw('{"ok":true}');
        $this->assertSame('1.1', $raw->getProtocolVersion());
        $this->assertSame(200, $raw->getStatusCode());
        $this->assertSame('OK', $raw->getReasonPhrase());
        $this->assertTrue($raw->hasHeader('Content-Type'));
        $this->assertSame(['application/json'], $raw->getHeader('Content-Type'));
        $this->assertSame('application/json', $raw->getHeaderLine('Content-Type'));
        $this->assertArrayHasKey('Content-Type', $raw->getHeaders());
        $this->assertSame('{"ok":true}', (string) $raw->getBody());

        $protocol = $raw->withProtocolVersion('2.0');
        $this->assertNotSame($raw, $protocol);
        $this->assertSame('2.0', $protocol->getProtocolVersion());
        $this->assertSame('1.1', $raw->getProtocolVersion());

        $header = $raw->withHeader('X-Test', 'one')->withAddedHeader('X-Test', 'two');
        $this->assertSame(['one', 'two'], $header->getHeader('X-Test'));
        $this->assertFalse($header->withoutHeader('X-Test')->hasHeader('X-Test'));

        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream('replacement');
        $this->assertSame('replacement', (string) $raw->withBody($stream)->getBody());
        $this->assertSame(201, $raw->withStatus(201, 'Created')->getStatusCode());
        $this->assertSame('Created', $raw->withStatus(201, 'Created')->getReasonPhrase());
    }

    /**
     * @param list<string|int>|string|int|null $unwrap
     * @param class-string<BasePage<mixed>>|null $page
     * @param class-string<BaseStream<mixed>>|null $stream
     *
     * @return RawResponse<mixed>
     */
    private function raw(
        string $body,
        array|string|int|null $unwrap = null,
        Converter|ConverterSource|string $convert = 'mixed',
        ?string $page = null,
        ?string $stream = null,
    ): RawResponse {
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $request = $requestFactory->createRequest('GET', 'https://example.test/items');
        $response = $responseFactory->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($streamFactory->createStream($body))
        ;
        $options = RequestOptions::with(
            transporter: new MockClient,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: $requestFactory,
            streamFactory: $streamFactory,
        );
        $client = new RawResponseClient(
            headers: [],
            baseUrl: 'https://example.test',
            options: $options,
        );
        $requestInfo = [
            'method' => 'GET',
            'path' => 'https://example.test/items',
            'query' => [],
            'headers' => [],
            'body' => null,
        ];

        return new RawResponse(
            client: $client,
            options: $options,
            request: $request,
            response: $response,
            requestInfo: $requestInfo,
            unwrap: $unwrap,
            convert: $convert,
            page: $page,
            stream: $stream,
        );
    }
}
