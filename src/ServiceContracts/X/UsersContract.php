<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Users\UserProfile;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface UsersContract
{
    /**
     * @api
     *
     * @param string $id X username (without @) or user ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): UserProfile;

    /**
     * @api
     *
     * @param string $ids Comma-separated user IDs (max 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveBatch(
        string $ids,
        RequestOptions|array|null $requestOptions = null
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedUsers;
}
