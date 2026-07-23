<?php

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;

/**
 * @internal
 */
final class ListsTest extends TestCase
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
    public function testRetrieveFollowers(): void
    {
        $result = $this->client->x->lists->retrieveFollowers('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testRetrieveMembers(): void
    {
        $result = $this->client->x->lists->retrieveMembers('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedUsers::class, $result);
    }

    #[Test]
    public function testRetrieveTweets(): void
    {
        $result = $this->client->x->lists->retrieveTweets('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }
}
