<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\XRawContract;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetHomeTimelineParams;
use XTwitterScraper\X\XGetHomeTimelineResponse;
use XTwitterScraper\X\XGetNotificationsParams;
use XTwitterScraper\X\XGetNotificationsParams\Type;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendsResponse;

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class XRawService implements XRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve the full content of an X Article (long-form post) by tweet ID.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/articles/%1$s', $tweetID],
            options: $requestOptions,
            convert: XGetArticleResponse::class,
        );
    }

    /**
     * @api
     *
     * Get home timeline
     *
     * @param array{
     *   cursor?: string, seenTweetIDs?: string
     * }|XGetHomeTimelineParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetHomeTimelineResponse>
     *
     * @throws APIException
     */
    public function getHomeTimeline(
        array|XGetHomeTimelineParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetHomeTimelineParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/timeline',
            query: Util::array_transform_keys(
                $parsed,
                ['seenTweetIDs' => 'seenTweetIds']
            ),
            options: $options,
            convert: XGetHomeTimelineResponse::class,
        );
    }

    /**
     * @api
     *
     * Get notifications
     *
     * @param array{
     *   cursor?: string, type?: Type|value-of<Type>
     * }|XGetNotificationsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetNotificationsResponse>
     *
     * @throws APIException
     */
    public function getNotifications(
        array|XGetNotificationsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetNotificationsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/notifications',
            query: $parsed,
            options: $options,
            convert: XGetNotificationsResponse::class,
        );
    }

    /**
     * @api
     *
     * Get trending topics
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendsResponse>
     *
     * @throws APIException
     */
    public function getTrends(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/trends',
            options: $requestOptions,
            convert: XGetTrendsResponse::class,
        );
    }
}
