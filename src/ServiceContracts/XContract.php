<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetNotificationsParams\Type;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendsResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface XContract
{
    /**
     * @api
     *
     * @param string $tweetID Numeric tweet ID of the article, 15-20 digits. If you have a tweet URL, use the final status ID.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getArticle(
        string $tweetID,
        RequestOptions|array|null $requestOptions = null
    ): XGetArticleResponse;

    /**
     * @api
     *
     * @param string $cursor Pagination cursor for timeline
     * @param string $seenTweetIDs Comma-separated tweet IDs to exclude from results. Empty entries are ignored.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getHomeTimeline(
        ?string $cursor = null,
        ?string $seenTweetIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $cursor Pagination cursor for notifications
     * @param Type|value-of<Type> $type Notification type filter. Unrecognized values fall back to All.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getNotifications(
        ?string $cursor = null,
        Type|string $type = 'All',
        RequestOptions|array|null $requestOptions = null,
    ): XGetNotificationsResponse;

    /**
     * @api
     *
     * @param int $count Number of trending topics to return (1-50, default 30)
     * @param int $woeid Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTrends(
        int $count = 30,
        int $woeid = 1,
        RequestOptions|array|null $requestOptions = null,
    ): XGetTrendsResponse;
}
