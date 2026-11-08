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
use XTwitterScraper\SearchSuggestions;
use XTwitterScraper\X\XAutocompleteSearchParams;
use XTwitterScraper\X\XGetArticleParams;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetHashflagsParams;
use XTwitterScraper\X\XGetHashflagsResponse;
use XTwitterScraper\X\XGetHomeTimelineParams;
use XTwitterScraper\X\XGetNewsStoryVersionsParams;
use XTwitterScraper\X\XGetNewsStoryVersionsResponse;
use XTwitterScraper\X\XGetNotificationsParams;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendLocationsParams;
use XTwitterScraper\X\XGetTrendLocationsResponse;
use XTwitterScraper\X\XGetTrendsHistoryParams;
use XTwitterScraper\X\XGetTrendsHistoryResponse;
use XTwitterScraper\X\XGetTrendsParams;
use XTwitterScraper\X\XGetTrendsResponse;
use XTwitterScraper\X\XSearchPlacesParams;
use XTwitterScraper\X\XSearchPlacesResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface XRawContract
{
    /**
     * @api
     *
     * @param string $tweetID Numeric tweet ID of the article, 15-20 digits. If you have a tweet URL, use the final status ID.
     * @param array<string,mixed>|XGetArticleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetArticleResponse>
     *
     * @throws APIException
     */
    public function getArticle(
        string $tweetID,
        array|XGetArticleParams $params = [],
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

    /**
     * @api
     *
     * @param array<string,mixed>|XGetTrendsHistoryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendsHistoryResponse>
     *
     * @throws APIException
     */
    public function getTrendsHistory(
        array|XGetTrendsHistoryParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XGetTrendLocationsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendLocationsResponse>
     *
     * @throws APIException
     */
    public function getTrendLocations(
        array|XGetTrendLocationsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XGetNewsStoryVersionsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetNewsStoryVersionsResponse>
     *
     * @throws APIException
     */
    public function getNewsStoryVersions(
        string $id,
        array|XGetNewsStoryVersionsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XGetHashflagsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetHashflagsResponse>
     *
     * @throws APIException
     */
    public function getHashflags(
        array|XGetHashflagsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XSearchPlacesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XSearchPlacesResponse>
     *
     * @throws APIException
     */
    public function searchPlaces(
        array|XSearchPlacesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|XAutocompleteSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SearchSuggestions>
     *
     * @throws APIException
     */
    public function autocompleteSearch(
        array|XAutocompleteSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
