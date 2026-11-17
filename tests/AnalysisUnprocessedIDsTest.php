<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

namespace Tests;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use XTwitterScraper\Client;
use XTwitterScraper\TweetAnalysisPage;

/**
 * @internal
 */
final class AnalysisUnprocessedIDsTest extends TestCase
{
    private const PAGE = [
        'results' => [],
        'unanalyzed' => [],
        'analysisSummary' => [
            'schemaVersion' => 1,
            'rows' => ['analyzed' => 0, 'failed' => 0, 'skipped' => 0],
            'engagement' => 0,
            'questions' => [],
        ],
        'has_next_page' => false,
        'next_cursor' => '',
    ];

    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'My API Key',
            baseUrl: 'http://127.0.0.1:4010',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    #[Test]
    #[DataProvider('routes')]
    public function testEachRouteReadsTheIDsTheTimeRanOutFor(string $method): void
    {
        $this->respond(self::PAGE + ['unprocessed_ids' => ['2', '3']]);

        $page = $this->client->x->analysis->{$method}(tweetIDs: ['1', '2', '3']);

        $this->assertInstanceOf(TweetAnalysisPage::class, $page);
        $this->assertSame(['2', '3'], $page->unprocessedIDs);
    }

    /**
     * @return list<array{string}>
     */
    public static function routes(): array
    {
        return [['sentiment'], ['brand'], ['news'], ['marketSignals'], ['viralScore'], ['classify']];
    }

    #[Test]
    public function testAPageThatFinishedInTimeReadsAnEmptyList(): void
    {
        $this->respond(self::PAGE + ['unprocessed_ids' => []]);

        $this->assertSame([], $this->client->x->analysis->sentiment(tweetIDs: ['1'])->unprocessedIDs);
    }

    #[Test]
    public function testAPageBuildsWithUnprocessedIDs(): void
    {
        $page = TweetAnalysisPage::with(
            results: [],
            unanalyzed: [],
            analysisSummary: self::PAGE['analysisSummary'],
            hasNextPage: false,
            nextCursor: '',
            unprocessedIDs: ['2'],
        );

        $this->assertSame(['2'], $page->unprocessedIDs);
        $this->assertSame(['4'], $page->withUnprocessedIDs(['4'])->unprocessedIDs);
        $this->assertSame([], $page->withUnprocessedIDs([])->unprocessedIDs);
        $this->assertSame(['2'], $page->unprocessedIDs);
    }

    /**
     * @param array<string,mixed> $page
     */
    private function respond(array $page): void
    {
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($page, JSON_THROW_ON_ERROR));
        $this->transporter->addResponse(
            $factory->createResponse(200)->withHeader('Content-Type', 'application/json')->withBody($stream)
        );
    }
}
