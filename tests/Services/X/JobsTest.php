<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\JobLocations;
use XTwitterScraper\PaginatedJobs;
use XTwitterScraper\X\Jobs\JobRetrieveResponse;

/**
 * @internal
 */
final class JobsTest extends TestCase
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
        $result = $this->client->x->jobs->search(q: 'q');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedJobs::class, $result);
    }

    #[Test]
    public function testListLocations(): void
    {
        $result = $this->client->x->jobs->listLocations(q: 'q');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(JobLocations::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        $result = $this->client->x->jobs->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(JobRetrieveResponse::class, $result);
    }
}
