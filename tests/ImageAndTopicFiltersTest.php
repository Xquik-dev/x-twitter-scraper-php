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
use Psr\Http\Message\RequestInterface;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Util;
use XTwitterScraper\ImageFilterSummary;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\SearchTweet;
use XTwitterScraper\TopicFilterSummary;
use XTwitterScraper\TweetAnalysisPage;
use XTwitterScraper\X\Analysis\AnalysisBrandParams;
use XTwitterScraper\X\Analysis\AnalysisClassifyParams;
use XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams;
use XTwitterScraper\X\Analysis\AnalysisNewsParams;
use XTwitterScraper\X\Analysis\AnalysisSentimentParams;
use XTwitterScraper\X\Analysis\AnalysisViralScoreParams;

/**
 * @internal
 *
 * @phpstan-import-type ImageFilterSummaryShape from ImageFilterSummary
 * @phpstan-import-type TopicFilterSummaryShape from TopicFilterSummary
 */
final class ImageAndTopicFiltersTest extends TestCase
{
    private MockClient $transporter;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transporter = new MockClient;
        $this->client = new Client(
            apiKey: 'My API Key',
            bearerToken: 'My Bearer Token',
            baseUrl: 'http://127.0.0.1:4010',
            requestOptions: ['transporter' => $this->transporter],
        );
    }

    #[Test]
    public function testSearchSendsTheFiltersAndReadsATopicPage(): void
    {
        $this->respond(self::page(['topicFilter' => self::topicFilter()], ['topicScore' => 0.92]));

        $page = $this->client->x->tweets->search(
            q: 'rust',
            imageShows: 'charts',
            topic: 'the Rust programming language',
        );

        $query = $this->query();
        $this->assertSame('the Rust programming language', $query['topic'] ?? null);
        $this->assertSame('charts', $query['imageShows'] ?? null);
        $this->assertInstanceOf(PaginatedTweets::class, $page);
        $this->assertInstanceOf(TopicFilterSummary::class, $page->topicFilter);
        $this->assertSame('the Rust programming language', $page->topicFilter->topic);
        $this->assertSame(0.5, $page->topicFilter->cutoff);
        $this->assertSame(3, $page->topicFilter->checked);
        $this->assertSame(1, $page->topicFilter->kept);
        $this->assertSame('model_error', $page->topicFilter->unchecked[0]->reason);
        $this->assertSame(0.92, self::post($page)->topicScore);
        $this->assertNull($page->imageFilter);
    }

    #[Test]
    #[DataProvider('userReads')]
    public function testUserReadsSendTheFiltersAndReadAnImagePage(string $method): void
    {
        $this->respond(self::page(['imageFilter' => self::imageFilter()], ['imageScore' => 0.81]));

        $users = $this->client->x->users;
        $page = match ($method) {
            'retrieveTweets' => $users->retrieveTweets('44196397', imageShows: 'charts', topic: 'rockets'),
            'retrieveReplies' => $users->retrieveReplies('44196397', imageShows: 'charts', topic: 'rockets'),
            default => $users->retrieveMedia('44196397', imageShows: 'charts', topic: 'rockets'),
        };

        $query = $this->query();
        $this->assertSame('rockets', $query['topic'] ?? null);
        $this->assertSame('charts', $query['imageShows'] ?? null);
        $this->assertInstanceOf(ImageFilterSummary::class, $page->imageFilter);
        $this->assertSame('charts', $page->imageFilter->imageShows);
        $this->assertSame(4, $page->imageFilter->kept);
        $this->assertSame('no_safe_photos', $page->imageFilter->unchecked[0]->reason);
        $this->assertSame(0.81, self::post($page)->imageScore);
        $this->assertNull($page->topicFilter);
    }

    /**
     * @return list<array{string}>
     */
    public static function userReads(): array
    {
        return [['retrieveTweets'], ['retrieveReplies'], ['retrieveMedia']];
    }

    #[Test]
    public function testAPlainPageHasNoFilterSummaries(): void
    {
        $this->respond(self::page([], []));

        $page = $this->client->x->users->retrieveTweets('44196397');

        $this->assertArrayNotHasKey('topic', $this->query());
        $this->assertNull($page->topicFilter);
        $this->assertNull($page->imageFilter);
        $this->assertNull(self::post($page)->topicScore);
        $this->assertNull(self::post($page)->imageScore);
    }

    #[Test]
    public function testExtractionsSendTheFiltersInTheBody(): void
    {
        $this->respond(['id' => '77', 'status' => 'running', 'toolType' => 'tweet_search_extractor']);
        $this->client->extractions->run(toolType: 'tweet_search_extractor', imageShows: 'charts', topic: 'rockets');
        $run = $this->body();

        $this->respond(['allowed' => true, 'estimatedResults' => 10, 'projectedPercent' => 1, 'source' => 'search', 'usagePercent' => 1]);
        $this->client->extractions->estimateCost(toolType: 'tweet_search_extractor', imageShows: 'charts', topic: 'rockets');
        $estimate = $this->body();

        foreach ([$run, $estimate] as $body) {
            $this->assertSame('rockets', $body['topic'] ?? null);
            $this->assertSame('charts', $body['imageShows'] ?? null);
        }
    }

    #[Test]
    public function testExtractionJobsReadBothFilterSummaries(): void
    {
        $this->respond([
            'extractions' => [[
                'id' => '77',
                'createdAt' => '2026-11-08T03:00:00Z',
                'status' => 'completed',
                'toolType' => 'tweet_search_extractor',
                'totalResults' => 1,
                'topicFilter' => self::topicFilter(),
                'imageFilter' => self::imageFilter(),
            ]],
            'hasMore' => false,
        ]);

        $job = $this->client->extractions->list()->extractions[0];

        $this->assertInstanceOf(TopicFilterSummary::class, $job->topicFilter);
        $this->assertSame(1, $job->topicFilter->kept);
        $this->assertInstanceOf(ImageFilterSummary::class, $job->imageFilter);
        $this->assertSame(16, $job->imageFilter->checked);
    }

    #[Test]
    public function testMediaDownloadSendsImageShowsAndReadsTheSummary(): void
    {
        $this->respond(['tweetId' => '1234567890', 'galleryUrl' => 'https://xquik.com/gallery/abc123', 'imageFilter' => self::imageFilter()]);

        $result = $this->client->x->media->download(imageShows: 'charts', tweetInput: '1234567890');

        $this->assertSame('charts', $this->body()['imageShows'] ?? null);
        $this->assertInstanceOf(ImageFilterSummary::class, $result->imageFilter);
        $this->assertSame('charts', $result->imageFilter->imageShows);
    }

    #[Test]
    #[DataProvider('analysisRoutes')]
    public function testAnalysisSendsTheFiltersAndReadsBothSummaries(string $method, string $path): void
    {
        $this->respond([
            'results' => [],
            'unanalyzed' => [],
            'analysisSummary' => [
                'schemaVersion' => 1,
                'rows' => ['analyzed' => 1, 'failed' => 0, 'skipped' => 0],
                'engagement' => 0,
                'questions' => [],
            ],
            'has_next_page' => false,
            'next_cursor' => '',
            'topicFilter' => self::topicFilter(),
            'imageFilter' => self::imageFilter(),
        ]);

        $page = $this->client->x->analysis->{$method}(
            query: 'rust',
            topic: 'the Rust programming language',
            imageShows: 'charts',
        );

        $body = $this->body();
        $this->assertStringEndsWith('/x/analysis/'.$path, $this->lastRequest()->getUri()->getPath());
        $this->assertSame('the Rust programming language', $body['topic'] ?? null);
        $this->assertSame('charts', $body['imageShows'] ?? null);
        $this->assertInstanceOf(TweetAnalysisPage::class, $page);
        $this->assertInstanceOf(TopicFilterSummary::class, $page->topicFilter);
        $this->assertSame('the Rust programming language', $page->topicFilter->topic);
        $this->assertSame(1, $page->topicFilter->kept);
        $this->assertInstanceOf(ImageFilterSummary::class, $page->imageFilter);
        $this->assertSame('charts', $page->imageFilter->imageShows);
        $this->assertSame(4, $page->imageFilter->kept);
    }

    /**
     * @return list<array{string,string}>
     */
    public static function analysisRoutes(): array
    {
        return [
            ['sentiment', 'sentiment'],
            ['brand', 'brand'],
            ['news', 'news'],
            ['marketSignals', 'market-signals'],
            ['viralScore', 'viral-score'],
            ['classify', 'classify'],
        ];
    }

    #[Test]
    public function testAnAnalysisPageWithoutFiltersHasNoSummaries(): void
    {
        $page = TweetAnalysisPage::with(
            results: [],
            unanalyzed: [],
            analysisSummary: ['schemaVersion' => 1, 'rows' => ['analyzed' => 0, 'failed' => 0, 'skipped' => 0], 'engagement' => 0, 'questions' => []],
            hasNextPage: false,
            nextCursor: '',
        );

        $this->assertNull($page->topicFilter);
        $this->assertNull($page->imageFilter);

        $filtered = $page->withTopicFilter(self::topicFilter())->withImageFilter(self::imageFilter());
        $this->assertSame(3, $filtered->topicFilter?->checked);
        $this->assertSame(16, $filtered->imageFilter?->checked);
    }

    /**
     * @param class-string<AnalysisBrandParams|AnalysisClassifyParams|AnalysisMarketSignalsParams|AnalysisNewsParams|AnalysisSentimentParams|AnalysisViralScoreParams> $class
     */
    #[Test]
    #[DataProvider('analysisParams')]
    public function testAnalysisParamsCarryTheFilters(string $class): void
    {
        $built = $class::with(topic: 'rockets', imageShows: 'charts');
        $this->assertSame('rockets', $built->topic);
        $this->assertSame('charts', $built->imageShows);

        $chained = (new $class)->withTopic('rockets')->withImageShows('charts');
        $this->assertSame('rockets', $chained->topic);
        $this->assertSame('charts', $chained->imageShows);
    }

    /**
     * @return list<array{class-string<AnalysisBrandParams|AnalysisClassifyParams|AnalysisMarketSignalsParams|AnalysisNewsParams|AnalysisSentimentParams|AnalysisViralScoreParams>}>
     */
    public static function analysisParams(): array
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

    private static function post(PaginatedTweets $page): SearchTweet
    {
        $post = $page->tweets[0];
        self::assertInstanceOf(SearchTweet::class, $post);

        return $post;
    }

    /**
     * @param array<string,mixed> $page
     * @param array<string,mixed> $post
     *
     * @return array<string,mixed>
     */
    private static function page(array $page, array $post): array
    {
        return [
            'tweets' => [[
                'id' => '1234567890',
                'bookmarkCount' => 0,
                'likeCount' => 3,
                'quoteCount' => 0,
                'replyCount' => 1,
                'retweetCount' => 0,
                'text' => 'Rust 1.92 is out',
                'viewCount' => 40,
                ...$post,
            ]],
            'has_next_page' => false,
            'next_cursor' => '',
            ...$page,
        ];
    }

    /**
     * @return TopicFilterSummaryShape
     */
    private static function topicFilter(): array
    {
        return [
            'topic' => 'the Rust programming language',
            'question' => 'Is this post about the Rust programming language?',
            'cutoff' => 0.5,
            'checked' => 3,
            'kept' => 1,
            'unchecked' => [['id' => '1234567891', 'reason' => 'model_error']],
        ];
    }

    /**
     * @return ImageFilterSummaryShape
     */
    private static function imageFilter(): array
    {
        return [
            'imageShows' => 'charts',
            'question' => 'Does a picture attached to this post show a chart?',
            'cutoff' => 0.5,
            'checked' => 16,
            'kept' => 4,
            'unchecked' => [['id' => '1234567892', 'reason' => 'no_safe_photos']],
        ];
    }

    /**
     * @param array<string,mixed> $payload
     */
    private function respond(array $payload): void
    {
        $factory = Psr17FactoryDiscovery::findResponseFactory();
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($payload, flags: Util::JSON_ENCODE_FLAGS) ?: '');
        $this->transporter->addResponse(
            $factory->createResponse(200)->withHeader('Content-Type', 'application/json')->withBody($stream)
        );
    }

    private function lastRequest(): RequestInterface
    {
        $requests = $this->transporter->getRequests();
        $this->assertNotEmpty($requests);

        return $requests[array_key_last($requests)];
    }

    /**
     * @return array<string,mixed>
     */
    private function query(): array
    {
        parse_str($this->lastRequest()->getUri()->getQuery(), $query);

        // @phpstan-ignore-next-line return.type
        return $query;
    }

    /**
     * @return array<string,mixed>
     */
    private function body(): array
    {
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertIsArray($body);

        // @phpstan-ignore-next-line return.type
        return $body;
    }
}
