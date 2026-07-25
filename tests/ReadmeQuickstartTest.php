<?php

namespace Tests;

use Http\Mock\Client;
use Xquik\TwitterScraper\Client as TwitterScraperClient;
use PHPUnit\Framework\TestCase;

class ReadmeQuickstartTest extends TestCase
{
    public function testReadmeQuickstartWithFakeTransport(): void
    {
        $mockClient = new Client();
        $client = new TwitterScraperClient($mockClient);
        $this->assertInstanceOf(TwitterScraperClient::class, $client);
    }
}
