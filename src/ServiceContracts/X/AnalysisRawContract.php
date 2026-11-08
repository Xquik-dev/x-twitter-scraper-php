<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\TweetAnalysisPage;
use XTwitterScraper\X\Analysis\AnalysisBrandParams;
use XTwitterScraper\X\Analysis\AnalysisClassifyParams;
use XTwitterScraper\X\Analysis\AnalysisMarketSignalsParams;
use XTwitterScraper\X\Analysis\AnalysisNewsParams;
use XTwitterScraper\X\Analysis\AnalysisSentimentParams;
use XTwitterScraper\X\Analysis\AnalysisViralScoreParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface AnalysisRawContract
{
    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
