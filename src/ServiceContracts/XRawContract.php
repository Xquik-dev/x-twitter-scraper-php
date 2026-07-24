<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetHomeTimelineParams;
use XTwitterScraper\X\XGetNotificationsParams;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendsParams;
use XTwitterScraper\X\XGetTrendsResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface XRawContract
{
    /**
     * @api
     *
     * @param string $tweetID Numeric tweet ID of the article, 15-20 digits. If you have a tweet URL, use the final status ID.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetArticleResponse>
     *
     * @throws APIException
     */
    public function getArticle(
        string $tweetID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XGetHomeTimelineParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function getHomeTimeline(
        array|XGetHomeTimelineParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XGetNotificationsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetNotificationsResponse>
     *
     * @throws APIException
     */
    public function getNotifications(
        array|XGetNotificationsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XGetTrendsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendsResponse>
     *
     * @throws APIException
     */
    public function getTrends(
        array|XGetTrendsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
