<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests\Services\X;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\FootballBoxScore;
use XTwitterScraper\FootballPlays;
use XTwitterScraper\FootballProps;
use XTwitterScraper\FootballRoster;
use XTwitterScraper\FootballSchedule;
use XTwitterScraper\FootballScoreboard;
use XTwitterScraper\SportsGameAudience;
use XTwitterScraper\SportsGamePosts;

/**
 * @internal
 */
final class SportsTest extends TestCase
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
    public function testListGames(): void
    {
        $result = $this->client->x->sports->listGames('league');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FootballSchedule::class, $result);
    }

    #[Test]
    public function testRetrieveScoreboard(): void
    {
        $result = $this->client->x->sports->retrieveScoreboard('league', 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FootballScoreboard::class, $result);
    }

    #[Test]
    public function testRetrieveAudience(): void
    {
        $result = $this->client->x->sports->retrieveAudience('league', 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SportsGameAudience::class, $result);
    }

    #[Test]
    public function testRetrieveBoxScore(): void
    {
        $result = $this->client->x->sports->retrieveBoxScore('league', 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FootballBoxScore::class, $result);
    }

    #[Test]
    public function testRetrievePlays(): void
    {
        $result = $this->client->x->sports->retrievePlays('league', 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FootballPlays::class, $result);
    }

    #[Test]
    public function testRetrieveRoster(): void
    {
        $result = $this->client->x->sports->retrieveRoster('league', 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FootballRoster::class, $result);
    }

    #[Test]
    public function testRetrievePlayerProps(): void
    {
        $result = $this->client->x->sports->retrievePlayerProps('league', 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FootballProps::class, $result);
    }

    #[Test]
    public function testListPosts(): void
    {
        $result = $this->client->x->sports->listPosts('league', 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SportsGamePosts::class, $result);
    }
}
