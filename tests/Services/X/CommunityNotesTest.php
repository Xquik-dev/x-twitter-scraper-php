<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedCommunityNotes;
use XTwitterScraper\X\CommunityNotes\CommunityNoteRetrieveContributorResponse;

/**
 * @internal
 */
final class CommunityNotesTest extends TestCase
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
    public function testRetrieveContributor(): void
    {
        $result = $this->client->x->communityNotes->retrieveContributor('alias');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CommunityNoteRetrieveContributorResponse::class, $result);
    }

    #[Test]
    public function testListContributorNotes(): void
    {
        $result = $this->client->x->communityNotes->listContributorNotes('alias');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedCommunityNotes::class, $result);
    }

    #[Test]
    public function testListContributorDeletedNotes(): void
    {
        $result = $this->client->x->communityNotes->listContributorDeletedNotes('alias');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(PaginatedCommunityNotes::class, $result);
    }
}
