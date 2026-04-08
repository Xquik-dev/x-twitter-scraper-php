<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\ListsRawContract;
use XTwitterScraper\X\Lists\ListGetFollowersResponse;
use XTwitterScraper\X\Lists\ListGetMembersResponse;
use XTwitterScraper\X\Lists\ListGetTweetsResponse;
use XTwitterScraper\X\Lists\ListRetrieveFollowersParams;
use XTwitterScraper\X\Lists\ListRetrieveMembersParams;
use XTwitterScraper\X\Lists\ListRetrieveTweetsParams;

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ListsRawService implements ListsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get list followers
     *
     * @param string $id List ID
     * @param array{cursor?: string}|ListRetrieveFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListGetFollowersResponse>
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        array|ListRetrieveFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ListRetrieveFollowersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/lists/%1$s/followers', $id],
            query: $parsed,
            options: $options,
            convert: ListGetFollowersResponse::class,
        );
    }

    /**
     * @api
     *
     * Get list members
     *
     * @param string $id List ID for member lookup
     * @param array{cursor?: string}|ListRetrieveMembersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListGetMembersResponse>
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        array|ListRetrieveMembersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ListRetrieveMembersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/lists/%1$s/members', $id],
            query: $parsed,
            options: $options,
            convert: ListGetMembersResponse::class,
        );
    }

    /**
     * @api
     *
     * Get list tweets
     *
     * @param string $id List ID for tweet lookup
     * @param array{
     *   cursor?: string, includeReplies?: bool, sinceTime?: string, untilTime?: string
     * }|ListRetrieveTweetsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListGetTweetsResponse>
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        array|ListRetrieveTweetsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ListRetrieveTweetsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/lists/%1$s/tweets', $id],
            query: $parsed,
            options: $options,
            convert: ListGetTweetsResponse::class,
        );
    }
}
