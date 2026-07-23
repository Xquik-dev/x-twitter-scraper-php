<?php

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;

/**
 * @internal
 */
final class BookmarksTest extends TestCase
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
    public function testList(): void
    {
        $result = $this->client->x->bookmarks->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedTweets::class, $result);
    }

    #[Test]
    public function testRetrieveFolders(): void
    {
        $result = $this->client->x->bookmarks->retrieveFolders();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BookmarkGetFoldersResponse::class, $result);
    }
}
