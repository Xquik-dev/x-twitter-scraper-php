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
use XTwitterScraper\Core\Util;
use XTwitterScraper\X\Analysis\AnalysisBrandParams;
use XTwitterScraper\X\Analysis\AnalysisClassifyParams;
use XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams;
use XTwitterScraper\X\Analysis\AnalysisNewsParams;
use XTwitterScraper\X\Analysis\AnalysisSentimentParams;
use XTwitterScraper\X\Analysis\AnalysisViralScoreParams;

/**
 * @internal
 */
final class AnalysisSourcesTest extends TestCase
{
    private const POST = '2102882545427714266';

    private const ACCOUNT = '@NASA';

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
    public function testEachRouteSendsTheSearchAndPageSources(string $method): void
    {
        $this->respond();
        $this->respond();

        $this->client->x->analysis->{$method}(
            queries: ['from:nasa', 'from:esa'],
            usernames: ['@NASA', '@ESA'],
            listIDs: ['4143408'],
        );
        $this->assertSame(
            ['listIds' => ['4143408'], 'queries' => ['from:nasa', 'from:esa'], 'usernames' => ['@NASA', '@ESA']],
            $this->sortedBody(0),
        );

        $this->client->x->analysis->{$method}(
            threadOf: self::POST,
            repliesBy: self::ACCOUNT,
            mediaBy: self::ACCOUNT,
            likedBy: self::ACCOUNT,
        );
        $this->assertSame(
            ['likedBy' => self::ACCOUNT, 'mediaBy' => self::ACCOUNT, 'repliesBy' => self::ACCOUNT, 'threadOf' => self::POST],
            $this->sortedBody(1),
        );
    }

    /**
     * @return list<array{string}>
     */
    public static function routes(): array
    {
        return [['sentiment'], ['brand'], ['news'], ['marketSignals'], ['viralScore'], ['classify']];
    }

    /**
     * @param class-string<AnalysisBrandParams|AnalysisClassifyParams|AnalysisMarketSignalsParams|AnalysisNewsParams|AnalysisSentimentParams|AnalysisViralScoreParams> $class
     */
    #[Test]
    #[DataProvider('params')]
    public function testEachParamsTypeCarriesTheSources(string $class): void
    {
        $built = $class::with(queries: ['from:nasa'], usernames: ['@NASA'], listIDs: ['4143408'], threadOf: self::POST);
        $this->assertSame(['from:nasa'], $built->queries);
        $this->assertSame(['@NASA'], $built->usernames);
        $this->assertSame(['4143408'], $built->listIDs);
        $this->assertSame(self::POST, $built->threadOf);

        $chained = (new $class)
            ->withQueries(['from:esa'])
            ->withUsernames(['@ESA'])
            ->withListIDs(['1970899750481260878'])
            ->withThreadOf(self::POST)
            ->withRepliesBy(self::ACCOUNT)
            ->withMediaBy(self::ACCOUNT)
            ->withLikedBy(self::ACCOUNT)
        ;
        $this->assertSame(['from:esa'], $chained->queries);
        $this->assertSame(['@ESA'], $chained->usernames);
        $this->assertSame(['1970899750481260878'], $chained->listIDs);
        $this->assertSame(
            [self::POST, self::ACCOUNT, self::ACCOUNT, self::ACCOUNT],
            [$chained->threadOf, $chained->repliesBy, $chained->mediaBy, $chained->likedBy],
        );
    }

    /**
     * @return list<array{class-string<AnalysisBrandParams|AnalysisClassifyParams|AnalysisMarketSignalsParams|AnalysisNewsParams|AnalysisSentimentParams|AnalysisViralScoreParams>}>
     */
    public static function params(): array
    {
        return [
            [AnalysisSentimentParams::class],
            [AnalysisBrandParams::class],
            [AnalysisNewsParams::class],
            [AnalysisMarketSignalsParams::class],
            [AnalysisViralScoreParams::class],
            [AnalysisClassifyParams::class],
        ];
    }

    private function respond(): void
    {
        $payload = [
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
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($payload, flags: Util::JSON_ENCODE_FLAGS) ?: '');
        $this->transporter->addResponse(
            $factory->createResponse(200)->withHeader('Content-Type', 'application/json')->withBody($stream)
        );
    }

    /**
     * @return array<string,mixed>
     */
    private function sortedBody(int $index): array
    {
        $requests = $this->transporter->getRequests();
        $this->assertArrayHasKey($index, $requests);
        $body = json_decode((string) $requests[$index]->getBody(), true);
        $this->assertIsArray($body);
        ksort($body);

        // @phpstan-ignore-next-line return.type
        return $body;
    }
}
