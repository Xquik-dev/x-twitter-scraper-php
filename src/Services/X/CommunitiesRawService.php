<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
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
     *   account: string, name: string, description?: string
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/communities',
            body: (object) $parsed,
            options: $options,
            convert: CommunityNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete community
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{
     *   account: string, communityName: string
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/communities/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: CommunityDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Get community details
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
     * Get community members
     *
     * @param string $id Community ID for member lookup
     * @param array{cursor?: string}|CommunityRetrieveMembersParams $params
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
     * Get community moderators
     *
     * @param string $id Community ID for moderator lookup
     * @param array{cursor?: string}|CommunityRetrieveModeratorsParams $params
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
     * Search tweets across communities
     *
     * @param array{
     *   q: string, cursor?: string, queryType?: string
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
            query: $parsed,
            options: $options,
            convert: PaginatedTweets::class,
        );
    }
}
