<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\TweetAnalysisPage;
use XTwitterScraper\TweetAnalysisSettings;
use XTwitterScraper\X\Analysis\AnalysisSentimentParams\Baseline;
use XTwitterScraper\X\Analysis\AnalysisSentimentParams\QueryType;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface AnalysisContract
{
    /**
     * @api
     *
     * @param list<string>|null $tweetIDs post IDs or post URLs to analyze, up to 100
     * @param string|null $query X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     * @param string|null $username Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     * @param string|null $listID Analyze a public List's posts. Send its ID or URL.
     * @param string|null $quotesOf Analyze the quotes of 1 post. Send its ID or URL.
     * @param string|null $repliesTo Analyze the replies in 1 post's conversation. Send its ID or URL.
     * @param mixed $sinceTime Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param mixed $untilTime Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param QueryType|value-of<QueryType>|null $queryType Search order. Default Latest.
     * @param int|null $limit Maximum posts to analyze from the search. A low credit balance can return fewer.
     * @param string|null $cursor The next_cursor of the page before. Send the same search with it.
     * @param list<string>|null $texts Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     * @param list<Baseline|array<string,mixed>>|null $baseline Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sentiment(
        ?array $tweetIDs = null,
        ?string $query = null,
        ?string $username = null,
        ?string $listID = null,
        ?string $quotesOf = null,
        ?string $repliesTo = null,
        mixed $sinceTime = null,
        mixed $untilTime = null,
        QueryType|string|null $queryType = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?array $texts = null,
        TweetAnalysisSettings|array|null $analysis = null,
        ?array $baseline = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetAnalysisPage;

    /**
     * @api
     *
     * @param list<string>|null $tweetIDs post IDs or post URLs to analyze, up to 100
     * @param string|null $query X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     * @param string|null $username Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     * @param string|null $listID Analyze a public List's posts. Send its ID or URL.
     * @param string|null $quotesOf Analyze the quotes of 1 post. Send its ID or URL.
     * @param string|null $repliesTo Analyze the replies in 1 post's conversation. Send its ID or URL.
     * @param mixed $sinceTime Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param mixed $untilTime Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param \XTwitterScraper\X\Analysis\AnalysisBrandParams\QueryType|value-of<\XTwitterScraper\X\Analysis\AnalysisBrandParams\QueryType>|null $queryType Search order. Default Latest.
     * @param int|null $limit Maximum posts to analyze from the search. A low credit balance can return fewer.
     * @param string|null $cursor The next_cursor of the page before. Send the same search with it.
     * @param list<string>|null $texts Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     * @param list<\XTwitterScraper\X\Analysis\AnalysisBrandParams\Baseline|array<string,mixed>>|null $baseline Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function brand(
        ?array $tweetIDs = null,
        ?string $query = null,
        ?string $username = null,
        ?string $listID = null,
        ?string $quotesOf = null,
        ?string $repliesTo = null,
        mixed $sinceTime = null,
        mixed $untilTime = null,
        \XTwitterScraper\X\Analysis\AnalysisBrandParams\QueryType|string|null $queryType = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?array $texts = null,
        TweetAnalysisSettings|array|null $analysis = null,
        ?array $baseline = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetAnalysisPage;

    /**
     * @api
     *
     * @param list<string>|null $tweetIDs post IDs or post URLs to analyze, up to 100
     * @param string|null $query X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     * @param string|null $username Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     * @param string|null $listID Analyze a public List's posts. Send its ID or URL.
     * @param string|null $quotesOf Analyze the quotes of 1 post. Send its ID or URL.
     * @param string|null $repliesTo Analyze the replies in 1 post's conversation. Send its ID or URL.
     * @param mixed $sinceTime Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param mixed $untilTime Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param \XTwitterScraper\X\Analysis\AnalysisNewsParams\QueryType|value-of<\XTwitterScraper\X\Analysis\AnalysisNewsParams\QueryType>|null $queryType Search order. Default Latest.
     * @param int|null $limit Maximum posts to analyze from the search. A low credit balance can return fewer.
     * @param string|null $cursor The next_cursor of the page before. Send the same search with it.
     * @param list<string>|null $texts Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     * @param list<\XTwitterScraper\X\Analysis\AnalysisNewsParams\Baseline|array<string,mixed>>|null $baseline Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function news(
        ?array $tweetIDs = null,
        ?string $query = null,
        ?string $username = null,
        ?string $listID = null,
        ?string $quotesOf = null,
        ?string $repliesTo = null,
        mixed $sinceTime = null,
        mixed $untilTime = null,
        \XTwitterScraper\X\Analysis\AnalysisNewsParams\QueryType|string|null $queryType = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?array $texts = null,
        TweetAnalysisSettings|array|null $analysis = null,
        ?array $baseline = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetAnalysisPage;

    /**
     * @api
     *
     * @param list<string>|null $tweetIDs post IDs or post URLs to analyze, up to 100
     * @param string|null $query X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     * @param string|null $username Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     * @param string|null $listID Analyze a public List's posts. Send its ID or URL.
     * @param string|null $quotesOf Analyze the quotes of 1 post. Send its ID or URL.
     * @param string|null $repliesTo Analyze the replies in 1 post's conversation. Send its ID or URL.
     * @param mixed $sinceTime Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param mixed $untilTime Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param \XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams\QueryType|value-of<\XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams\QueryType>|null $queryType Search order. Default Latest.
     * @param int|null $limit Maximum posts to analyze from the search. A low credit balance can return fewer.
     * @param string|null $cursor The next_cursor of the page before. Send the same search with it.
     * @param list<string>|null $texts Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     * @param list<\XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams\Baseline|array<string,mixed>>|null $baseline Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function marketSignals(
        ?array $tweetIDs = null,
        ?string $query = null,
        ?string $username = null,
        ?string $listID = null,
        ?string $quotesOf = null,
        ?string $repliesTo = null,
        mixed $sinceTime = null,
        mixed $untilTime = null,
        \XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams\QueryType|string|null $queryType = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?array $texts = null,
        TweetAnalysisSettings|array|null $analysis = null,
        ?array $baseline = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetAnalysisPage;

    /**
     * @api
     *
     * @param list<string>|null $tweetIDs post IDs or post URLs to analyze, up to 100
     * @param string|null $query X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     * @param string|null $username Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     * @param string|null $listID Analyze a public List's posts. Send its ID or URL.
     * @param string|null $quotesOf Analyze the quotes of 1 post. Send its ID or URL.
     * @param string|null $repliesTo Analyze the replies in 1 post's conversation. Send its ID or URL.
     * @param mixed $sinceTime Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param mixed $untilTime Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param \XTwitterScraper\X\Analysis\AnalysisViralScoreParams\QueryType|value-of<\XTwitterScraper\X\Analysis\AnalysisViralScoreParams\QueryType>|null $queryType Search order. Default Latest.
     * @param int|null $limit Maximum posts to analyze from the search. A low credit balance can return fewer.
     * @param string|null $cursor The next_cursor of the page before. Send the same search with it.
     * @param list<string>|null $texts Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     * @param list<\XTwitterScraper\X\Analysis\AnalysisViralScoreParams\Baseline|array<string,mixed>>|null $baseline Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function viralScore(
        ?array $tweetIDs = null,
        ?string $query = null,
        ?string $username = null,
        ?string $listID = null,
        ?string $quotesOf = null,
        ?string $repliesTo = null,
        mixed $sinceTime = null,
        mixed $untilTime = null,
        \XTwitterScraper\X\Analysis\AnalysisViralScoreParams\QueryType|string|null $queryType = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?array $texts = null,
        TweetAnalysisSettings|array|null $analysis = null,
        ?array $baseline = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetAnalysisPage;

    /**
     * @api
     *
     * @param list<string>|null $tweetIDs post IDs or post URLs to analyze, up to 100
     * @param string|null $query X search to analyze, with the operators of /x/tweets/search, such as from:nasa or lang:en. X searches up to 512 characters, counted with the other search fields, as /x/tweets/search counts q.
     * @param string|null $username Analyze 1 account's posts. Send a handle, with or without @, or a profile URL.
     * @param string|null $listID Analyze a public List's posts. Send its ID or URL.
     * @param string|null $quotesOf Analyze the quotes of 1 post. Send its ID or URL.
     * @param string|null $repliesTo Analyze the replies in 1 post's conversation. Send its ID or URL.
     * @param mixed $sinceTime Inclusive start of the search, such as 2026-09-25T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param mixed $untilTime Exclusive end of the search, such as 2026-09-26T00:00:00Z. Unix seconds also work. A time without an offset is UTC.
     * @param \XTwitterScraper\X\Analysis\AnalysisClassifyParams\QueryType|value-of<\XTwitterScraper\X\Analysis\AnalysisClassifyParams\QueryType>|null $queryType Search order. Default Latest.
     * @param int|null $limit Maximum posts to analyze from the search. A low credit balance can return fewer.
     * @param string|null $cursor The next_cursor of the page before. Send the same search with it.
     * @param list<string>|null $texts Your own texts to analyze, such as drafts. Reads nothing from X. Each text costs the same as 1 analyzed post.
     * @param TweetAnalysisSettings|array<string,mixed>|null $analysis Analysis settings, the same as the analysis input of Xquik's AI Actors, plus images. Leave it out for the route's own questions.
     * @param list<\XTwitterScraper\X\Analysis\AnalysisClassifyParams\Baseline|array<string,mixed>>|null $baseline Rows of an earlier answer to compare with, such as its results. Each needs the post's id, or tweet.id, & its answers. Send monitor too, so other settings show as not_comparable. Each result's monitor says whether the post is new, changed or unchanged. The comparison costs nothing extra.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function classify(
        ?array $tweetIDs = null,
        ?string $query = null,
        ?string $username = null,
        ?string $listID = null,
        ?string $quotesOf = null,
        ?string $repliesTo = null,
        mixed $sinceTime = null,
        mixed $untilTime = null,
        \XTwitterScraper\X\Analysis\AnalysisClassifyParams\QueryType|string|null $queryType = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?array $texts = null,
        TweetAnalysisSettings|array|null $analysis = null,
        ?array $baseline = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetAnalysisPage;
}
