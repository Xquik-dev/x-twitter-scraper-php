<?php

namespace Tests\Core;

use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use XTwitterScraper\Core\BaseClient;
use XTwitterScraper\RequestOptions;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class BaseClientTest extends TestCase
{
    #[Test]
    public function testInvalidRetryAfterDateUsesFallbackDelay(): void
    {
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $response = $factory
            ->createResponse(429)
            ->withHeader('retry-after', 'not-a-date')
        ;
        $options = RequestOptions::with(
            initialRetryDelay: 1,
            maxRetryDelay: 1,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
        );
        $client = new class(headers: [], baseUrl: 'http://localhost', options: $options) extends BaseClient {
            public function retryDelayForTest(
                RequestOptions $options,
                int $retryCount,
                ResponseInterface $response,
            ): float {
                return $this->retryDelay($options, $retryCount, $response);
            }
        };

        $delay = $client->retryDelayForTest($options, 1, $response);

        $this->assertGreaterThanOrEqual(0.75, $delay);
        $this->assertLessThanOrEqual(1.0, $delay);
    }
}
