<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\UsersContract;
use XTwitterScraper\Services\X\Users\FollowService;
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

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class UsersService implements UsersContract
{
    /**
     * @api
     */
    public UsersRawService $raw;

    /**
     * @api
     */
    public FollowService $follow;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UsersRawService($client);
        $this->follow = new FollowService($client);
    }

    /**
     * @api
     *
     * Get multiple users by IDs
     *
     * @param string $ids Comma-separated user IDs (max 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveBatch(
        string $ids,
        RequestOptions|array|null $requestOptions = null
    ): UserGetBatchResponse {
        $params = Util::removeNulls(['ids' => $ids]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveBatch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get user followers
     *
     * @param string $id User ID or username
     * @param string $cursor Pagination cursor for followers list
     * @param int $pageSize Items per page (20-200, default 200)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetFollowersResponse {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get followers you know for a user
     *
     * @param string $id User ID for followers-you-know lookup
     * @param string $cursor Pagination cursor for followers-you-know
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowersYouKnow(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetFollowersYouKnowResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowersYouKnow($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get users this user follows
     *
     * @param string $id User ID or username for following lookup
     * @param string $cursor Pagination cursor for following list
     * @param int $pageSize Results per page (20-200, default 200)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetFollowingResponse {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowing($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get tweets liked by a user
     *
     * @param string $id User ID
     * @param string $cursor Pagination cursor for liked tweets
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLikes(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetLikesResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveLikes($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get media tweets by a user
     *
     * @param string $id User ID for media lookup
     * @param string $cursor Pagination cursor for media tweets
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMedia(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetMediaResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMedia($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get tweets mentioning a user
     *
     * @param string $id User ID or username for mentions lookup
     * @param string $cursor Pagination cursor for mentions
     * @param string $sinceTime Unix timestamp - return mentions after this time
     * @param string $untilTime Unix timestamp - return mentions before this time
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMentions(
        string $id,
        ?string $cursor = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetMentionsResponse {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'sinceTime' => $sinceTime,
                'untilTime' => $untilTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMentions($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search users by name or username
     *
     * @param string $q User search query
     * @param string $cursor Pagination cursor for user search
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $q,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetSearchResponse {
        $params = Util::removeNulls(['q' => $q, 'cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get recent tweets by a user
     *
     * @param string $id X user ID or username
     * @param string $cursor Pagination cursor for user tweets
     * @param bool $includeParentTweet Include parent tweet for replies
     * @param bool $includeReplies Include reply tweets
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        ?string $cursor = null,
        bool $includeParentTweet = false,
        bool $includeReplies = false,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetTweetsResponse {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'includeParentTweet' => $includeParentTweet,
                'includeReplies' => $includeReplies,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTweets($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get verified followers
     *
     * @param string $id User ID or username for verified followers
     * @param string $cursor Pagination cursor for verified followers
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserGetVerifiedFollowersResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveVerifiedFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
