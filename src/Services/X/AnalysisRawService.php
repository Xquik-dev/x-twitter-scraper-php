<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AnalysisRawContract;
use XTwitterScraper\TweetAnalysisPage;
use XTwitterScraper\X\Analysis\AnalysisBrandParams;
use XTwitterScraper\X\Analysis\AnalysisClassifyParams;
use XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams;
use XTwitterScraper\X\Analysis\AnalysisNewsParams;
use XTwitterScraper\X\Analysis\AnalysisSentimentParams;
use XTwitterScraper\X\Analysis\AnalysisViralScoreParams;

/**
 * Analysis operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class AnalysisRawService implements AnalysisRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Answers each post's attitude, its intensity & its sarcasm probability. Sentiment analysis names each post's main emotion, such as joy or anger. Send post IDs, an X search, an account, a List, a post's replies or quotes, or your own texts. Each analyzed post costs 2 credits. A post without an analysis costs nothing.
     *
     * @param array<string,mixed>|AnalysisSentimentParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetAnalysisPage>
     *
     * @throws APIException
     */
    public function sentiment(
        array|AnalysisSentimentParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AnalysisSentimentParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/analysis/sentiment',
            body: (object) $parsed,
            options: $options,
            convert: TweetAnalysisPage::class,
        );
    }

    /**
     * @api
     *
     * Answers whether each post is about your brand, the author's attitude toward it & the author's relationship with it. Name the brand in analysis.targets. Each analyzed post costs 2 credits.
     *
     * @param array<string,mixed>|AnalysisBrandParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetAnalysisPage>
     *
     * @throws APIException
     */
    public function brand(
        array|AnalysisBrandParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AnalysisBrandParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/analysis/brand',
            body: (object) $parsed,
            options: $options,
            convert: TweetAnalysisPage::class,
        );
    }

    /**
     * @api
     *
     * Answers each post's format, such as reporting, commentary or speculation, its source attribution & its relevance to your topic. Name the topic in analysis.targets. Each analyzed post costs 2 credits.
     *
     * @param array<string,mixed>|AnalysisNewsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetAnalysisPage>
     *
     * @throws APIException
     */
    public function news(
        array|AnalysisNewsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AnalysisNewsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/analysis/news',
            body: (object) $parsed,
            options: $options,
            convert: TweetAnalysisPage::class,
        );
    }

    /**
     * @api
     *
     * Answers each post's stance on an asset, its content type, its conviction & its relevance. The summary counts bullish & bearish posts per cashtag. Name the asset in analysis.targets. Each analyzed post costs 2 credits.
     *
     * @param array<string,mixed>|AnalysisMarketSignalsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetAnalysisPage>
     *
     * @throws APIException
     */
    public function marketSignals(
        array|AnalysisMarketSignalsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AnalysisMarketSignalsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/analysis/market-signals',
            body: (object) $parsed,
            options: $options,
            convert: TweetAnalysisPage::class,
        );
    }

    /**
     * @api
     *
     * Answers each post's hook, clarity, payoff, humor, spam risk & likely reaction, & adds a Viral Score from 0 to 100 with a verdict. The score rates the wording. It does not predict likes or views. Send drafts in texts to score them before posting. Each analyzed post costs 2 credits.
     *
     * `viralAlgorithmScore` turns a post's public counts into 1 comparable number.
     *
     * @param array<string,mixed>|AnalysisViralScoreParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetAnalysisPage>
     *
     * @throws APIException
     */
    public function viralScore(
        array|AnalysisViralScoreParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AnalysisViralScoreParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/analysis/viral-score',
            body: (object) $parsed,
            options: $options,
            convert: TweetAnalysisPage::class,
        );
    }

    /**
     * @api
     *
     * Answers 1 to 8 questions you write in analysis.questions. A choice picks a category, such as a topic. A score picks a level. A probability answers yes or no. Without questions it answers the sentiment questions. Each analyzed post costs 2 credits.
     *
     * @param array<string,mixed>|AnalysisClassifyParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetAnalysisPage>
     *
     * @throws APIException
     */
    public function classify(
        array|AnalysisClassifyParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AnalysisClassifyParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/analysis/classify',
            body: (object) $parsed,
            options: $options,
            convert: TweetAnalysisPage::class,
        );
    }
}
