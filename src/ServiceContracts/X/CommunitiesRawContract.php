<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\CommunityAnalytics;
use XTwitterScraper\CommunityPage;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\CommunityCreateParams;
use XTwitterScraper\X\Communities\CommunityDeleteParams;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityFindParams;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityListPopularParams;
use XTwitterScraper\X\Communities\CommunityListSuggestedParams;
use XTwitterScraper\X\Communities\CommunityListSuggestedResponse;
use XTwitterScraper\X\Communities\CommunityListTopicsParams;
use XTwitterScraper\X\Communities\CommunityListTopicsResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;
use XTwitterScraper\X\Communities\CommunityRetrieveAnalyticsParams;
use XTwitterScraper\X\Communities\CommunityRetrieveInfoParams;
use XTwitterScraper\X\Communities\CommunityRetrieveMembersParams;
use XTwitterScraper\X\Communities\CommunityRetrieveModeratorsParams;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams;
use XTwitterScraper\X\Communities\CommunitySearchMembersParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface CommunitiesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|CommunityCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CommunityCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id path param: Resource ID returned by the matching create or list endpoint
     * @param array<string,mixed>|CommunityDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|CommunityDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Community ID
     * @param array<string,mixed>|CommunityRetrieveInfoParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityGetInfoResponse>
     *
     * @throws APIException
     */
    public function retrieveInfo(
        string $id,
        array|CommunityRetrieveInfoParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Community ID for member lookup
     * @param array<string,mixed>|CommunityRetrieveMembersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        array|CommunityRetrieveMembersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Community ID for moderator lookup
     * @param array<string,mixed>|CommunityRetrieveModeratorsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveModerators(
        string $id,
        array|CommunityRetrieveModeratorsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunityRetrieveSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveSearch(
        array|CommunityRetrieveSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunityRetrieveAnalyticsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityAnalytics>
     *
     * @throws APIException
     */
    public function retrieveAnalytics(
        string $id,
        array|CommunityRetrieveAnalyticsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunitySearchMembersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function searchMembers(
        string $id,
        array|CommunitySearchMembersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunityFindParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityPage>
     *
     * @throws APIException
     */
    public function find(
        array|CommunityFindParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunityListPopularParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityPage>
     *
     * @throws APIException
     */
    public function listPopular(
        array|CommunityListPopularParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunityListTopicsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityListTopicsResponse>
     *
     * @throws APIException
     */
    public function listTopics(
        array|CommunityListTopicsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CommunityListSuggestedParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityListSuggestedResponse>
     *
     * @throws APIException
     */
    public function listSuggested(
        array|CommunityListSuggestedParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
