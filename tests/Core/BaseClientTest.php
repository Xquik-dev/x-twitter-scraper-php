<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace Tests\Core;

use Http\Client\Exception\NetworkException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use XTwitterScraper\Core\BaseClient;
use XTwitterScraper\Core\Exceptions\APIConnectionException;
use XTwitterScraper\Core\Exceptions\APIStatusException;
use XTwitterScraper\Core\Exceptions\AuthenticationException;
use XTwitterScraper\Core\Exceptions\BadRequestException;
use XTwitterScraper\Core\Exceptions\ConflictException;
use XTwitterScraper\Core\Exceptions\InternalServerException;
use XTwitterScraper\Core\Exceptions\NotFoundException;
use XTwitterScraper\Core\Exceptions\PermissionDeniedException;
use XTwitterScraper\Core\Exceptions\RateLimitException;
use XTwitterScraper\Core\Exceptions\UnprocessableEntityException;
use XTwitterScraper\RequestOptions;

/**
 * @internal
 *
 * @phpstan-import-type NormalizedRequest from \XTwitterScraper\Core\BaseClient
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class InspectableClient extends BaseClient
{
    /**
     * @param string|list<mixed> $path
     * @param array<string,mixed> $query
     * @param array<string,string|int|list<string|int>|null> $headers
     * @param RequestOpts|null $options
     *
     * @return array{NormalizedRequest, RequestOptions}
     */
    public function inspectBuild(
        string $method,
        string|array $path,
        array $query,
        array $headers,
        mixed $body,
        RequestOptions|array|null $options,
    ): array {
        return $this->buildRequest($method, $path, $query, $headers, $body, $options);
    }

    public function inspectShouldRetry(
        RequestOptions $options,
        int $retryCount,
        ?ResponseInterface $response,
    ): bool {
        return $this->shouldRetry($options, $retryCount, $response);
    }

    public function inspectRetryDelay(
        RequestOptions $options,
        int $retryCount,
        ?ResponseInterface $response,
    ): float {
        return $this->retryDelay($options, $retryCount, $response);
    }

    public function inspectFollowRedirect(
        ResponseInterface $response,
        RequestInterface $request,
    ): RequestInterface {
        return $this->followRedirect($response, $request);
    }

    /**
     * @param bool|int|float|string|resource|\Traversable<mixed,mixed>|array<string,mixed>|null $body
     */
    public function inspectSend(
        RequestOptions $options,
        RequestInterface $request,
        mixed $body = null,
        int $retryCount = 0,
        int $redirectCount = 0,
    ): ResponseInterface {
        return $this->sendRequest($options, $request, $body, $retryCount, $redirectCount);
    }
}

/**
 * @internal
 */
final class BaseClientTest extends TestCase
{
    #[Test]
    public function testBuildRequestMergesEveryDocumentedOverride(): void
    {
        $options = $this->options()->withExtraHeaders([
            'Shared' => 'extra',
            'Extra' => 'header',
        ])->withExtraQueryParams([
            'shared' => 'extra',
            'extra' => true,
        ])->withExtraBodyParams([
            'shared' => 'extra',
            'extra' => 2,
        ]);
        $client = new InspectableClient(
            headers: ['Default' => 'header', 'Shared' => 'default'],
            baseUrl: 'https://example.test/api',
            idempotencyHeader: 'Idempotency-Key',
            options: $options,
        );

        [$request, $parsedOptions] = $client->inspectBuild(
            'post',
            ['/items/%s', 'a value'],
            ['shared' => 'request'],
            ['Shared' => 'request'],
            ['shared' => 'body', 'base' => 1],
            null,
        );

        $this->assertSame($options->timeout, $parsedOptions->timeout);
        $this->assertSame('POST', $request['method']);
        $this->assertSame(
            'https://example.test/items/a%20value?shared%5B0%5D=request&shared%5B1%5D=extra&extra=true',
            $request['path'],
        );
        $this->assertSame(['shared' => ['request', 'extra'], 'extra' => true], $request['query']);
        $this->assertSame('header', $request['headers']['Default']);
        $this->assertSame('extra', $request['headers']['Shared']);
        $this->assertSame('header', $request['headers']['Extra']);
        $idempotencyKey = $request['headers']['Idempotency-Key'];
        $this->assertIsString($idempotencyKey);
        $this->assertMatchesRegularExpression(
            '/^stainless-php-retry-[0-9a-f]{64}$/',
            $idempotencyKey,
        );
        $this->assertSame(
            ['shared' => 'extra', 'base' => 1, 'extra' => 2],
            $request['body'],
        );

        [$withExplicitKey] = $client->inspectBuild(
            'GET',
            '/',
            [],
            ['Idempotency-Key' => 'caller-key'],
            null,
            [],
        );
        $this->assertSame('caller-key', $withExplicitKey['headers']['Idempotency-Key']);

        $resource = fopen('php://temp', 'w+');
        $this->assertIsResource($resource);
        [, $oneShotOptions] = $client->inspectBuild(
            'POST',
            '/',
            [],
            [],
            ['upload' => $resource],
            null,
        );
        $this->assertSame(0, $oneShotOptions->maxRetries);
        fclose($resource);
    }

    #[Test]
    public function testRetryPolicyCoversConnectionsAndRetryableStatuses(): void
    {
        $options = $this->options()->withMaxRetries(2);
        $client = $this->client($options);

        $this->assertTrue($client->inspectShouldRetry($options, 0, null));
        foreach ([408, 409, 429, 500, 503] as $status) {
            $this->assertTrue(
                $client->inspectShouldRetry($options, 0, $this->response($status)),
                "HTTP {$status}",
            );
        }
        foreach ([200, 400, 401, 404, 422] as $status) {
            $this->assertFalse(
                $client->inspectShouldRetry($options, 0, $this->response($status)),
                "HTTP {$status}",
            );
        }
        $this->assertFalse($client->inspectShouldRetry($options, 2, $this->response(503)));
    }

    #[Test]
    public function testRetryDelaySupportsSecondsDatesBackoffJitterAndCap(): void
    {
        $options = $this->options()
            ->withInitialRetryDelay(2)
            ->withMaxRetryDelay(100)
        ;
        $client = $this->client($options);

        $this->assertSame(
            1.25,
            $client->inspectRetryDelay($options, 0, $this->response(429, ['retry-after' => '1.25'])),
        );

        $future = gmdate('D, d M Y H:i:s \G\M\T', time() + 3);
        $dateDelay = $client->inspectRetryDelay(
            $options,
            0,
            $this->response(429, ['retry-after' => $future]),
        );
        $this->assertGreaterThanOrEqual(2, $dateDelay);
        $this->assertLessThanOrEqual(3, $dateDelay);

        $past = gmdate('D, d M Y H:i:s \G\M\T', time() - 60);
        $this->assertSame(
            0.0,
            $client->inspectRetryDelay($options, 0, $this->response(429, ['retry-after' => $past])),
        );

        $initial = $client->inspectRetryDelay(
            $options,
            0,
            $this->response(429, ['retry-after' => 'not-a-date']),
        );
        $this->assertGreaterThanOrEqual(1.5, $initial);
        $this->assertLessThanOrEqual(2.0, $initial);

        $later = $client->inspectRetryDelay($options, 2, null);
        $this->assertGreaterThanOrEqual(6.0, $later);
        $this->assertLessThanOrEqual(8.0, $later);

        $capped = $client->inspectRetryDelay(
            $options->withInitialRetryDelay(100)->withMaxRetryDelay(3),
            2,
            null,
        );
        $this->assertSame(3.0, $capped);
    }

    #[Test]
    public function testRedirectHandlingRequiresLocationAndPreservesAuthority(): void
    {
        $client = $this->client($this->options());
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test/old')
        ;

        $redirected = $client->inspectFollowRedirect(
            $this->response(302, ['Location' => '/new']),
            $request,
        );
        $this->assertSame('https://example.test/new', (string) $redirected->getUri());

        $this->expectException(APIConnectionException::class);
        $this->expectExceptionMessage('Redirection without Location header');
        $client->inspectFollowRedirect($this->response(302), $request);
    }

    #[Test]
    public function testRedirectHandlingBlocksCredentialExfiltration(): void
    {
        $client = $this->client($this->options());
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test/old')
            ->withHeader('Authorization', 'Bearer test-token')
        ;

        foreach ([
            'http://example.test/downgrade',
            'https://other.test/cross-origin',
            'https://user@example.test/user-info',
            'https://example.test:444/other-port',
        ] as $location) {
            try {
                $client->inspectFollowRedirect(
                    $this->response(302, ['Location' => $location]),
                    $request,
                );
                $this->fail("Expected {$location} to be blocked.");
            } catch (APIConnectionException $exception) {
                $this->assertStringContainsString('Cross-origin redirect blocked', $exception->getMessage());
                $this->assertSame('Bearer test-token', $exception->request->getHeaderLine('Authorization'));
            }
        }

        $sameOrigin = $client->inspectFollowRedirect(
            $this->response(302, ['Location' => 'https://EXAMPLE.test:443/safe']),
            $request,
        );
        $this->assertSame('https://example.test/safe', (string) $sameOrigin->getUri());
    }

    #[Test]
    public function testRequestRetriesNetworkAndServerFailuresThenParsesSuccess(): void
    {
        $transport = new MockClient;
        $requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $request = $requestFactory->createRequest('POST', 'https://example.test/items')
            ->withHeader('Content-Type', 'application/json')
        ;
        $transport->addException(new NetworkException('offline', $request));
        $transport->addResponse($this->response(200, ['Content-Type' => 'application/json'], '{"ok":true}'));
        $options = $this->options($transport)
            ->withMaxRetries(1)
            ->withInitialRetryDelay(0)
            ->withMaxRetryDelay(0)
        ;
        $client = $this->client($options);

        $response = $client->inspectSend($options, $request, ['name' => 'Xquik']);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertCount(2, $transport->getRequests());
        $this->assertSame('0', $transport->getRequests()[0]->getHeaderLine('X-Stainless-Retry-Count'));
        $this->assertSame('1', $transport->getRequests()[1]->getHeaderLine('X-Stainless-Retry-Count'));
        $this->assertSame('{"name":"Xquik"}', (string) $transport->getRequests()[1]->getBody());

        $transport = new MockClient;
        $transport->addResponse($this->response(503));
        $transport->addResponse($this->response(200));
        $options = $this->options($transport)
            ->withMaxRetries(1)
            ->withInitialRetryDelay(0)
            ->withMaxRetryDelay(0)
        ;
        $client = $this->client($options);
        $this->assertSame(200, $client->inspectSend($options, $request)->getStatusCode());
        $this->assertCount(2, $transport->getRequests());
    }

    #[Test]
    public function testRequestFollowsRedirectAndEnforcesRedirectLimit(): void
    {
        $transport = new MockClient;
        $transport->addResponse($this->response(302, ['Location' => '/next']));
        $transport->addResponse($this->response(200));
        $options = $this->options($transport)->withMaxRetries(0);
        $client = $this->client($options);
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test/start')
        ;

        $this->assertSame(200, $client->inspectSend($options, $request)->getStatusCode());
        $this->assertSame('https://example.test/next', (string) $transport->getRequests()[1]->getUri());

        $transport = new MockClient;
        $transport->setDefaultResponse($this->response(302, ['Location' => '/loop']));
        $options = $this->options($transport)->withMaxRetries(0);
        $client = $this->client($options);
        $this->expectException(APIConnectionException::class);
        $this->expectExceptionMessage('Maximum redirects exceeded');
        $client->inspectSend($options, $request, redirectCount: 20);
    }

    #[Test]
    public function testExhaustedNetworkFailurePreservesCause(): void
    {
        $transport = new MockClient;
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test')
        ;
        $cause = new NetworkException('offline', $request);
        $transport->addException($cause);
        $options = $this->options($transport)->withMaxRetries(0);
        $client = $this->client($options);

        try {
            $client->inspectSend($options, $request);
            $this->fail('Expected the connection failure.');
        } catch (APIConnectionException $exception) {
            $this->assertSame($cause, $exception->getPrevious());
            $this->assertSame((string) $request->getUri(), (string) $exception->request->getUri());
            $this->assertSame('0', $exception->request->getHeaderLine('X-Stainless-Retry-Count'));
        }
    }

    /**
     * @param class-string<APIStatusException> $expected
     */
    #[DataProvider('statusExceptions')]
    #[Test]
    public function testStatusExceptionMapping(int $status, string $expected): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test')
        ;
        $exception = APIStatusException::from(
            $request,
            $this->response($status, body: '{"error":"reason"}'),
            'Request failed.',
        );

        $this->assertInstanceOf($expected, $exception);
        $this->assertSame($status, $exception->status);
        $this->assertSame(['error' => 'reason'], $exception->body);
        $this->assertStringContainsString("\nRequest failed.\n{", $exception->getMessage());
        $this->assertSame($request, $exception->request);
    }

    /**
     * @return array<string,array{int,class-string<APIStatusException>}>
     */
    public static function statusExceptions(): array
    {
        return [
            'bad request' => [400, BadRequestException::class],
            'authentication' => [401, AuthenticationException::class],
            'permission' => [403, PermissionDeniedException::class],
            'not found' => [404, NotFoundException::class],
            'conflict' => [409, ConflictException::class],
            'unprocessable' => [422, UnprocessableEntityException::class],
            'rate limit' => [429, RateLimitException::class],
            'internal' => [500, InternalServerException::class],
            'generic' => [418, APIStatusException::class],
        ];
    }

    #[Test]
    public function testStatusExceptionHandlesNonJsonResponse(): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('GET', 'https://example.test')
        ;
        $exception = APIStatusException::from(
            $request,
            $this->response(502, body: '<html>gateway failure</html>'),
        );

        $this->assertInstanceOf(InternalServerException::class, $exception);
        $this->assertNull($exception->body);
        $this->assertStringContainsString('"body": null', $exception->getMessage());
    }

    private function client(RequestOptions $options): InspectableClient
    {
        return new InspectableClient(
            headers: [],
            baseUrl: 'https://example.test',
            options: $options,
        );
    }

    private function options(?MockClient $transport = null): RequestOptions
    {
        return RequestOptions::with(
            transporter: $transport ?? new MockClient,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );
    }

    /**
     * @param array<string,string> $headers
     */
    private function response(int $status, array $headers = [], string $body = ''): ResponseInterface
    {
        $response = Psr17FactoryDiscovery::findResponseFactory()->createResponse($status);
        foreach ($headers as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        return $response->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body));
    }
}
