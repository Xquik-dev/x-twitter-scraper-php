<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\CommunityAnalytics;
use XTwitterScraper\CommunityPage;
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
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\QueryType;
use XTwitterScraper\X\Communities\CommunitySearchMembersParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
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
    ): BaseResponse {
        [$parsed, $options] = CommunityRetrieveInfoParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/info', $id],
            query: $parsed,
            options: $options,
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

    /**
     * @api
     *
     * Returns community activity for X's latest period. Includes likes, new members, posts, replies & unique posters. Each metric has a count and a changePercent. Each request costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = CommunityRetrieveAnalyticsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/analytics', $id],
            query: $parsed,
            options: $options,
            convert: CommunityAnalytics::class,
        );
    }

    /**
     * @api
     *
     * Finds a community's members by name or username, each with its role. An answer holds up to 10 members. Each member costs 1 credit. An answer without members is free.
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
    ): BaseResponse {
        [$parsed, $options] = CommunitySearchMembersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/members/search', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * Returns the communities X finds for a keyword, in X's order. Each community costs 1 credit. To search the tweets in Communities, use /x/communities/search.
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
    ): BaseResponse {
        [$parsed, $options] = CommunityFindParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/communities/find',
            query: $parsed,
            options: $options,
            convert: CommunityPage::class,
        );
    }

    /**
     * @api
     *
     * Returns the communities X ranks highest under a topic or subtopic. Name it by topicId or by topic name from /x/communities/topics. Each community costs 1 credit. A missing or unknown topic returns invalid_community_topic & lists the topic names.
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
    ): BaseResponse {
        [$parsed, $options] = CommunityListPopularParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/communities/popular',
            query: $parsed,
            options: $options,
            convert: CommunityPage::class,
        );
    }

    /**
     * @api
     *
     * Returns the community topics with their subtopics. Pass an ID as topicId, or a name as topic, to /x/communities/popular. Each top-level topic costs 1 credit, its subtopics included.
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
    ): BaseResponse {
        [$parsed, $options] = CommunityListTopicsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/communities/topics',
            query: $parsed,
            options: $options,
            convert: CommunityListTopicsResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the communities X suggests, with their full public fields. X picks them per request, so 2 calls can differ. An empty list is free. Each community costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = CommunityListSuggestedParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/communities/suggested',
            query: $parsed,
            options: $options,
            convert: CommunityListSuggestedResponse::class,
        );
    }
}
