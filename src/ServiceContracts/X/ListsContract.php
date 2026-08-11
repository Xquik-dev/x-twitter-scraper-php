<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ListsContract
{
    /**
     * @api
     *
     * @param string $id List ID
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for list followers
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). Source, filters, or credits can return fewer profiles. Keep requesting next_cursor while has_next_page is true. Deprecated aliases remain accepted.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers;

    /**
     * @api
     *
     * @param string $id List ID for member lookup
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for list members
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param int $pageSize Members per page (20-200, default 20)
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        int $pageSize = 20,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers;

    /**
     * @api
     *
     * @param string $id List ID for tweet lookup
     * @param string $cursor Pagination cursor for list tweets
     * @param bool $includeReplies Include replies (default false)
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param string $sinceTime Unix timestamp - filter after
     * @param string $untilTime Unix timestamp - filter before
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        ?string $cursor = null,
        ?bool $includeReplies = null,
        int $pageSize = 20,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;
}
