<?php

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
use XTwitterScraper\X\XGetTrendsResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface XRawContract
{
    /**
     * @api
     *
     * @param string $tweetID Tweet ID of the article
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendsResponse>
     *
     * @throws APIException
     */
    public function getTrends(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
