<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\UsersContract;
use XTwitterScraper\Services\X\Users\FollowService;
use XTwitterScraper\X\Users\UserProfile;

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
     * Look up X user
     *
     * @param string $username X username (without @)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): UserProfile {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($username, requestOptions: $requestOptions);

        return $response->parse();
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
    ): mixed {
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
     * @param string $cursor Pagination cursor
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
    ): mixed {
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
     * @param string $id User ID
     * @param string $cursor Pagination cursor from previous response
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowersYouKnow(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
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
     * @param string $id User ID or username
     * @param string $cursor Pagination cursor
     * @param int $pageSize Items per page (20-200, default 200)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
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
     * @param string $cursor Pagination cursor from previous response
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLikes(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
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
     * @param string $id User ID
     * @param string $cursor Pagination cursor from previous response
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMedia(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
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
     * @param string $id User ID or username
     * @param string $cursor Pagination cursor
     * @param string $sinceTime Unix timestamp - filter after
     * @param string $untilTime Unix timestamp - filter before
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
    ): mixed {
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
     * @param string $q Search query
     * @param string $cursor Pagination cursor
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $q,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
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
     * @param string $cursor Pagination cursor from previous response
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
    ): PaginatedTweets {
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
     * @param string $id User ID or username
     * @param string $cursor Pagination cursor
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveVerifiedFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
