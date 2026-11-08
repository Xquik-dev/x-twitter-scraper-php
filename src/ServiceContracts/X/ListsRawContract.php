<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedLists;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Lists\ListRetrieveFollowersParams;
use XTwitterScraper\X\Lists\ListRetrieveMembersParams;
use XTwitterScraper\X\Lists\ListRetrieveParams;
use XTwitterScraper\X\Lists\ListRetrieveResponse;
use XTwitterScraper\X\Lists\ListRetrieveSearchParams;
use XTwitterScraper\X\Lists\ListRetrieveTweetsParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface ListsRawContract
{
    /**
     * @api
     *
     * @param string $id List ID
     * @param array<string,mixed>|ListRetrieveFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        array|ListRetrieveFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id List ID for member lookup
     * @param array<string,mixed>|ListRetrieveMembersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        array|ListRetrieveMembersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id List ID for tweet lookup
     * @param array<string,mixed>|ListRetrieveTweetsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        array|ListRetrieveTweetsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ListRetrieveSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedLists>
     *
     * @throws APIException
     */
    public function retrieveSearch(
        array|ListRetrieveSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ListRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListRetrieveResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|ListRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
