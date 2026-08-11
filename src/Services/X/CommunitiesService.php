<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\CommunitiesContract;
use XTwitterScraper\Services\X\Communities\JoinService;
use XTwitterScraper\Services\X\Communities\TweetsService;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\QueryType;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class CommunitiesService implements CommunitiesContract
{
    /**
     * @api
     */
    public CommunitiesRawService $raw;

    /**
     * @api
     */
    public JoinService $join;

    /**
     * @api
     */
    public TweetsService $tweets;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CommunitiesRawService($client);
        $this->join = new JoinService($client);
        $this->tweets = new TweetsService($client);
    }

    /**
     * @api
     *
     * Create community
     *
     * @param string $account Body param: X account (@username or ID) creating the community
     * @param string $name Body param: Community name
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param string $description Body param: Community description
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $account,
        string $name,
        string $idempotencyKey,
        ?string $description = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityNewResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'name' => $name,
                'idempotencyKey' => $idempotencyKey,
                'description' => $description,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete community
     *
     * @param string $id path param: Resource ID returned by the matching create or list endpoint
     * @param string $account Body param: X account (@username or ID) deleting the community
     * @param string $communityName Body param: Community name for confirmation
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $account,
        string $communityName,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityDeleteResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'communityName' => $communityName,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get community name, description and member count
     *
     * @param string $id Community ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveInfo(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): CommunityGetInfoResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveInfo($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List members of a community
     *
     * @param string $id Community ID for member lookup
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor
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
     * @param int $pageSize Items per page (20-200, default 20). This is an upper bound for paid authenticated calls: remaining credits can reduce the returned page size, and zero affordable results returns 402 insufficient_credits.
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
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMembers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List moderators of a community
     *
     * @param string $id Community ID for moderator lookup
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for community moderators
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
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveModerators(
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
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveModerators($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns tweets, not community records. Requires a Community ID.
     *
     * @param string $communityID Numeric ID of the community whose posts to search
     * @param string $q Search query
     * @param string $cursor Pagination cursor for community search
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param QueryType|value-of<QueryType> $queryType Sort order (Latest or Top)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $communityID,
        string $q,
        ?string $cursor = null,
        int $pageSize = 20,
        QueryType|string $queryType = 'Latest',
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'communityID' => $communityID,
                'q' => $q,
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'queryType' => $queryType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
