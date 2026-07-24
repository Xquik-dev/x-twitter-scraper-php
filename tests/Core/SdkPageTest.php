<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests\Core;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Concerns\SdkPage;
use XTwitterScraper\Core\Contracts\BasePage;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\RequestOptions;

/**
 * @implements BasePage<mixed>
 *
 * @phpstan-import-type NormalizedRequest from \XTwitterScraper\Core\BaseClient
 */
final class SdkTestPage implements BasePage
{
    /** @use SdkPage<mixed> */
    use SdkPage;

    /** @var NormalizedRequest */
    private array $requestInfo;

    private RequestOptions $options;

    /** @var list<int> */
    private array $items;

    private ?string $nextPath;

    /**
     * @param NormalizedRequest $requestInfo
     * @param array{items?: list<int>, next?: string|null} $parsedBody
     */
    public function __construct(
        Converter|ConverterSource|string $convert,
        Client $client,
        array $requestInfo,
        RequestOptions $options,
        public ResponseInterface $response,
        array $parsedBody,
    ) {
        $this->convert = $convert;
        $this->client = $client;
        $this->requestInfo = $requestInfo;
        $this->options = $options;
        $this->items = $parsedBody['items'] ?? [];
        $this->nextPath = $parsedBody['next'] ?? null;
    }

    /**
     * @return list<int>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return array{NormalizedRequest, RequestOptions}|null
     */
    protected function nextRequest(): ?array
    {
        if (is_null($this->nextPath)) {
            return null;
        }

        return [[...$this->requestInfo, 'path' => $this->nextPath], $this->options];
    }
}

/**
 * @internal
 */
final class SdkPageTest extends TestCase
{
    #[Test]
    public function testPageIterationAndMissingNextPageGuard(): void
    {
        [$client, $options] = $this->client(new MockClient);
        $page = $this->page($client, $options, ['items' => [1, 2], 'next' => null]);

        $this->assertFalse($page->hasNextPage());
        $this->assertSame([$page], iterator_to_array($page, preserve_keys: false));
        $this->assertSame([1, 2], iterator_to_array($page->pagingEachItem(), preserve_keys: false));

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No next page expected');
        $page->getNextPage();
    }

    #[Test]
    public function testGetNextPageUsesStoredRequestAndOptions(): void
    {
        $transport = new MockClient;
        for ($index = 0; $index < 3; ++$index) {
            $response = Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(200)
                ->withHeader('Content-Type', 'application/json')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(
                    '{"items":[3],"next":null}',
                ))
            ;
            $transport->addResponse($response);
        }
        [$client, $options] = $this->client($transport);
        $page = $this->page($client, $options, ['items' => [1, 2], 'next' => '/page-2']);

        $this->assertTrue($page->hasNextPage());
        $next = $page->getNextPage();
        $this->assertSame([3], $next->getItems());
        $this->assertSame('https://example.test/page-2', (string) $transport->getRequests()[0]->getUri());
        $this->assertSame(
            [[1, 2], [3]],
            array_map(
                static fn (SdkTestPage $item): array => $item->getItems(),
                iterator_to_array($page, preserve_keys: false),
            ),
        );
        $this->assertSame(
            [1, 2, 3],
            iterator_to_array($page->pagingEachItem(), preserve_keys: false),
        );
    }

    /**
     * @return array{Client, RequestOptions}
     */
    private function client(MockClient $transport): array
    {
        $options = RequestOptions::with(
            transporter: $transport,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );
        $client = new Client(
            baseUrl: 'https://example.test',
            apiKey: 'test-api-key',
            requestOptions: $options,
        );

        return [$client, $options];
    }

    /**
     * @param array{items: list<int>, next: string|null} $body
     */
    private function page(Client $client, RequestOptions $options, array $body): SdkTestPage
    {
        return new SdkTestPage(
            convert: 'int',
            client: $client,
            requestInfo: [
                'method' => 'GET',
                'path' => '/page-1',
                'query' => [],
                'headers' => [],
                'body' => null,
            ],
            options: $options,
            response: Psr17FactoryDiscovery::findResponseFactory()->createResponse(200),
            parsedBody: $body,
        );
    }
}
