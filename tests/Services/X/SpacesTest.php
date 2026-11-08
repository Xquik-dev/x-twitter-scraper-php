<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Spaces\SpaceRetrieveReplayResponse;
use XTwitterScraper\X\Spaces\SpaceRetrieveResponse;
use XTwitterScraper\X\Spaces\SpaceSearchResponse;

/**
 * @internal
 */
final class SpacesTest extends TestCase
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
    public function testSearch(): void
    {
        $result = $this->client->x->spaces->search(q: 'q');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpaceSearchResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->x->spaces->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpaceRetrieveResponse::class, $result);
    }

    #[Test]
    public function testRetrieveReplay(): void
    {
        $result = $this->client->x->spaces->retrieveReplay('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SpaceRetrieveReplayResponse::class, $result);
    }
}
