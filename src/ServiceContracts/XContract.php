<?php

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
     * @param string $tweetID Tweet ID of the article
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
     * @param string $seenTweetIDs Comma-separated tweet IDs to exclude from results
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
     * @param Type|value-of<Type> $type Notification type filter
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTrends(
        RequestOptions|array|null $requestOptions = null
    ): XGetTrendsResponse;
}
