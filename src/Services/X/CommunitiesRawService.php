<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\CommunitiesRawContract;
use XTwitterScraper\X\Communities\CommunityCreateParams;
use XTwitterScraper\X\Communities\CommunityDeleteParams;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;
use XTwitterScraper\X\Communities\CommunityRetrieveMembersParams;
use XTwitterScraper\X\Communities\CommunityRetrieveModeratorsParams;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\QueryType;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class CommunitiesRawService implements CommunitiesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create community
     *
     * @param array{
     *   account: string, name: string, idempotencyKey: string, description?: string
     * }|CommunityCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|CommunityCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CommunityCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/communities',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: CommunityNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete community
     *
     * @param string $id path param: Resource ID returned by the matching create or list endpoint
     * @param array{
     *   account: string, communityName: string, idempotencyKey: string
     * }|CommunityDeleteParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CommunityDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/communities/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: CommunityDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Get community name, description and member count
     *
     * @param string $id Community ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityGetInfoResponse>
     *
     * @throws APIException
     */
    public function retrieveInfo(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/info', $id],
            options: $requestOptions,
            convert: CommunityGetInfoResponse::class,
        );
    }

    /**
     * @api
     *
     * List members of a community
     *
     * @param string $id Community ID for member lookup
     * @param array{
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   pageSize?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|CommunityRetrieveMembersParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CommunityRetrieveMembersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/members', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * List moderators of a community
     *
     * @param string $id Community ID for moderator lookup
     * @param array{
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|CommunityRetrieveModeratorsParams $params
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
    ): BaseResponse {
        [$parsed, $options] = CommunityRetrieveModeratorsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/moderators', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * Returns tweets, not community records. Requires a Community ID.
     *
     * @param array{
     *   communityID: string,
     *   q: string,
     *   cursor?: string,
     *   pageSize?: int,
     *   queryType?: QueryType|value-of<QueryType>,
     * }|CommunityRetrieveSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveSearch(
        array|CommunityRetrieveSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CommunityRetrieveSearchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/communities/search',
            query: Util::array_transform_keys(
                $parsed,
                ['communityID' => 'communityId']
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }
}
