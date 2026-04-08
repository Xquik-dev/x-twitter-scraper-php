<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\UsersRawContract;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse;
use XTwitterScraper\X\Users\UserGetFollowersYouKnowResponse;
use XTwitterScraper\X\Users\UserGetFollowingResponse;
use XTwitterScraper\X\Users\UserGetLikesResponse;
use XTwitterScraper\X\Users\UserGetMediaResponse;
use XTwitterScraper\X\Users\UserGetMentionsResponse;
use XTwitterScraper\X\Users\UserGetSearchResponse;
use XTwitterScraper\X\Users\UserGetTweetsResponse;
use XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse;
use XTwitterScraper\X\Users\UserRetrieveBatchParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersYouKnowParams;
use XTwitterScraper\X\Users\UserRetrieveFollowingParams;
use XTwitterScraper\X\Users\UserRetrieveLikesParams;
use XTwitterScraper\X\Users\UserRetrieveMediaParams;
use XTwitterScraper\X\Users\UserRetrieveMentionsParams;
use XTwitterScraper\X\Users\UserRetrieveSearchParams;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams;
use XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams;

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class UsersRawService implements UsersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get multiple users by IDs
     *
     * @param array{ids: string}|UserRetrieveBatchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetBatchResponse>
     *
     * @throws APIException
     */
    public function retrieveBatch(
        array|UserRetrieveBatchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveBatchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/users/batch',
            query: $parsed,
            options: $options,
            convert: UserGetBatchResponse::class,
        );
    }

    /**
     * @api
     *
     * Get user followers
     *
     * @param string $id User ID or username
     * @param array{
     *   cursor?: string, pageSize?: int
     * }|UserRetrieveFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetFollowersResponse>
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        array|UserRetrieveFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/followers', $id],
            query: $parsed,
            options: $options,
            convert: UserGetFollowersResponse::class,
        );
    }

    /**
     * @api
     *
     * Get followers you know for a user
     *
     * @param string $id User ID for followers-you-know lookup
     * @param array{cursor?: string}|UserRetrieveFollowersYouKnowParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetFollowersYouKnowResponse>
     *
     * @throws APIException
     */
    public function retrieveFollowersYouKnow(
        string $id,
        array|UserRetrieveFollowersYouKnowParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowersYouKnowParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/followers-you-know', $id],
            query: $parsed,
            options: $options,
            convert: UserGetFollowersYouKnowResponse::class,
        );
    }

    /**
     * @api
     *
     * Get users this user follows
     *
     * @param string $id User ID or username for following lookup
     * @param array{
     *   cursor?: string, pageSize?: int
     * }|UserRetrieveFollowingParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetFollowingResponse>
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        array|UserRetrieveFollowingParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowingParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/following', $id],
            query: $parsed,
            options: $options,
            convert: UserGetFollowingResponse::class,
        );
    }

    /**
     * @api
     *
     * Get tweets liked by a user
     *
     * @param string $id User ID
     * @param array{cursor?: string}|UserRetrieveLikesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetLikesResponse>
     *
     * @throws APIException
     */
    public function retrieveLikes(
        string $id,
        array|UserRetrieveLikesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveLikesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/likes', $id],
            query: $parsed,
            options: $options,
            convert: UserGetLikesResponse::class,
        );
    }

    /**
     * @api
     *
     * Get media tweets by a user
     *
     * @param string $id User ID for media lookup
     * @param array{cursor?: string}|UserRetrieveMediaParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetMediaResponse>
     *
     * @throws APIException
     */
    public function retrieveMedia(
        string $id,
        array|UserRetrieveMediaParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveMediaParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/media', $id],
            query: $parsed,
            options: $options,
            convert: UserGetMediaResponse::class,
        );
    }

    /**
     * @api
     *
     * Get tweets mentioning a user
     *
     * @param string $id User ID or username for mentions lookup
     * @param array{
     *   cursor?: string, sinceTime?: string, untilTime?: string
     * }|UserRetrieveMentionsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetMentionsResponse>
     *
     * @throws APIException
     */
    public function retrieveMentions(
        string $id,
        array|UserRetrieveMentionsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveMentionsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/mentions', $id],
            query: $parsed,
            options: $options,
            convert: UserGetMentionsResponse::class,
        );
    }

    /**
     * @api
     *
     * Search users by name or username
     *
     * @param array{q: string, cursor?: string}|UserRetrieveSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetSearchResponse>
     *
     * @throws APIException
     */
    public function retrieveSearch(
        array|UserRetrieveSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveSearchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/users/search',
            query: $parsed,
            options: $options,
            convert: UserGetSearchResponse::class,
        );
    }

    /**
     * @api
     *
     * Get recent tweets by a user
     *
     * @param string $id X user ID or username
     * @param array{
     *   cursor?: string, includeParentTweet?: bool, includeReplies?: bool
     * }|UserRetrieveTweetsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetTweetsResponse>
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        array|UserRetrieveTweetsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveTweetsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/tweets', $id],
            query: $parsed,
            options: $options,
            convert: UserGetTweetsResponse::class,
        );
    }

    /**
     * @api
     *
     * Get verified followers
     *
     * @param string $id User ID or username for verified followers
     * @param array{cursor?: string}|UserRetrieveVerifiedFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetVerifiedFollowersResponse>
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        array|UserRetrieveVerifiedFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveVerifiedFollowersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/verified-followers', $id],
            query: $parsed,
            options: $options,
            convert: UserGetVerifiedFollowersResponse::class,
        );
    }
}
