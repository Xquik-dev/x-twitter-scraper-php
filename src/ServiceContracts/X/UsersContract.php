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
     * @param string $username X username (without @)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $username,
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
    ): mixed;

    /**
     * @api
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
    ): mixed;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): mixed;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): mixed;

    /**
     * @api
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
    ): mixed;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): mixed;
}
