<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\BatchUserTweets;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedLists;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\UsersContract;
use XTwitterScraper\Services\X\Users\FollowService;
use XTwitterScraper\ShadowbanReport;
use XTwitterScraper\UserLiveStatus;
use XTwitterScraper\UserProfile;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse;
use XTwitterScraper\X\Users\UserRemoveFollowerResponse;
use XTwitterScraper\X\Users\UserRetrieveFollowerAuditResponse;
use XTwitterScraper\X\Users\UserRetrieveFollowersParams\Mode;
use XTwitterScraper\X\Users\UserRetrieveInsightsResponse;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\MediaType;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Quotes;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Replies;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Retweets;
use XTwitterScraper\X\Users\UserRetrieveMentionsParams\OwnThreads;
use XTwitterScraper\X\Users\UserTranslateBioResponse;
use XTwitterScraper\XWriteAction;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
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
     * Get user profile with follower counts and verification
     *
     * @param string $id X username (without @) or user ID
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null
    ): UserProfile {
        $params = Util::removeNulls(
            [
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove follower
     *
     * @param string $id Path param: User ID to remove from your followers
     * @param string $account Body param: X account identifier (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function removeFollower(
        string $id,
        string $account,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): UserRemoveFollowerResponse {
        $params = Util::removeNulls(
            ['account' => $account, 'idempotencyKey' => $idempotencyKey]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->removeFollower($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Look up multiple users by IDs in one call
     *
     * @param string $ids Comma-separated numeric user IDs (1-100 values). Duplicate IDs are ignored while preserving first-seen order.
     * @param string|null $usernames Comma-separated X usernames, with or without @, or profile links such as x.com/nasa (1-100 values), in place of ids. A name in another case is the same account. A longer URL fails at the edge before Xquik reads it.
     * @param int|null $minFollowers Minimum follower count. Profiles the filter drops cost nothing.
     * @param int|null $maxFollowers Maximum follower count. A profile without a count passes.
     * @param int|null $minFollowing profiles must follow at least this many accounts
     * @param int|null $maxFollowing profiles may follow at most this many accounts
     * @param int|null $minStatuses Minimum post count. minPosts is also accepted.
     * @param int|null $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int|null $minAccountAgeDays minimum account age in whole days
     * @param bool|null $verifiedOnly only return verified profiles
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param string|null $verifiedType match the verification type exactly, ignoring case
     * @param bool|null $hasWebsite only return profiles with a website
     * @param bool|null $hasLocation only return profiles with a location
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param string|null $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string|null $locationContains match a location substring, ignoring case
     * @param string|null $usernameContains match a username substring, ignoring case
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveBatch(
        string $ids,
        ?string $usernames = null,
        ?int $minFollowers = null,
        ?int $maxFollowers = null,
        ?int $minFollowing = null,
        ?int $maxFollowing = null,
        ?int $minStatuses = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?bool $verifiedOnly = null,
        ?bool $blueVerifiedOnly = null,
        ?string $verifiedType = null,
        ?bool $hasWebsite = null,
        ?bool $hasLocation = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?string $bioContains = null,
        ?string $locationContains = null,
        ?string $usernameContains = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null
    ): UserGetBatchResponse {
        $params = Util::removeNulls(['omit' => $omit, 'fields' => $fields, 'usernameContains' => $usernameContains, 'locationContains' => $locationContains, 'bioContains' => $bioContains, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'hasLocation' => $hasLocation, 'hasWebsite' => $hasWebsite, 'verifiedType' => $verifiedType, 'blueVerifiedOnly' => $blueVerifiedOnly, 'verifiedOnly' => $verifiedOnly, 'minAccountAgeDays' => $minAccountAgeDays, 'maxStatuses' => $maxStatuses, 'minStatuses' => $minStatuses, 'maxFollowing' => $maxFollowing, 'minFollowing' => $minFollowing, 'maxFollowers' => $maxFollowers, 'minFollowers' => $minFollowers, 'usernames' => $usernames, 'ids' => $ids]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveBatch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List followers of a user
     *
     * @param string $id target user ID or username for follower lookup
     * @param string $after Legacy cursor alias. Prefer cursor.
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param int $limit Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param Mode|value-of<Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param int $pageSize Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param int|null $maxScan Most profiles 1 request reads, kept or dropped by the filters. The request then answers the profiles it kept, the count it dropped & the cursor to read on. Each request of a cursor may send its own value. Without it, a filtered read scans at most 100,000 profiles of the list across all its pages, & the page that reaches them ends the list with `scanLimit`. An unfiltered read has no scan limit. Automatic mode only.
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param bool|null $enrichProfiles Add each row's full profile, as GET /x/users/{id} returns it. Pages take several seconds longer.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        ?string $after = null,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?int $limit = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        Mode|string|null $mode = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        ?int $maxScan = null,
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?bool $enrichProfiles = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers|UserListCoverageResponse {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'enrichProfiles' => $enrichProfiles, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxScan' => $maxScan,
                'after' => $after,
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'limit' => $limit,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'mode' => $mode,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List mutual followers between you and a user
     *
     * @param string $id User ID for followers-you-know lookup
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for followers-you-know
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
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowersYouKnow(
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
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly,
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
        $response = $this->raw->retrieveFollowersYouKnow($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List accounts a user follows
     *
     * @param string $id User ID or username for following lookup
     * @param string $after Deprecated following cursor alias. Prefer cursor.
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param int $limit Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveFollowingParams\Mode|value-of<\XTwitterScraper\X\Users\UserRetrieveFollowingParams\Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param int $pageSize Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param int|null $maxScan Most profiles 1 request reads, kept or dropped by the filters. The request then answers the profiles it kept, the count it dropped & the cursor to read on. Each request of a cursor may send its own value. Without it, a filtered read scans at most 100,000 profiles of the list across all its pages, & the page that reaches them ends the list with `scanLimit`. An unfiltered read has no scan limit. Automatic mode only.
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param bool|null $enrichProfiles Add each row's full profile, as GET /x/users/{id} returns it. Pages take several seconds longer.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        ?string $after = null,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?int $limit = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        \XTwitterScraper\X\Users\UserRetrieveFollowingParams\Mode|string|null $mode = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        ?int $maxScan = null,
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?bool $enrichProfiles = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers|\XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'enrichProfiles' => $enrichProfiles, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxScan' => $maxScan,
                'after' => $after,
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'limit' => $limit,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'mode' => $mode,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowing($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets liked by a user
     *
     * @param string $id User ID or username
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for liked tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param MediaType|value-of<MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param Quotes|value-of<Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param Replies|value-of<Replies> $replies reply mode
     * @param Retweets|value-of<Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLikes(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        ?int $minLikes = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'minLikes' => $minLikes,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveLikes($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List media tweets posted by a user
     *
     * @param string $id User ID or username for media lookup
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for media tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $imageShows Keep only posts whose photos show this. Send charts, screenshots, product_photos, memes or people, or describe it in words, such as a rocket. AI-powered analysis checks posts with photos X doesn't mark sensitive & keeps scores of 0.5 or more. Other posts stay out at no charge. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. imageFilter states the cutoff & counts.
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $topic Keep only posts about this topic. AI-powered analysis asks "Is this post about <topic>?" of each post & keeps scores of 0.5 or more. It reads post text & safe photos. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. limit counts checked posts, & only kept posts come back. topicFilter states the cutoff & counts.
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMedia(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $imageShows = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $topic = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        ?int $minLikes = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'minLikes' => $minLikes,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'imageShows' => $imageShows,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'topic' => $topic,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMedia($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets mentioning a user
     *
     * @param string $id User ID or username for mentions lookup
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for mentions
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $sinceTime Unix timestamp - return mentions after this time
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return mentions before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param OwnThreads|value-of<OwnThreads>|null $ownThreads with replies=exclude, also leaves out replies to the author's own posts, so the search skips every reply
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMentions(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $sinceTime = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        ?int $minLikes = null,
        ?string $fields = null,
        ?string $omit = null,
        OwnThreads|string|null $ownThreads = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'minLikes' => $minLikes,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'sinceTime' => $sinceTime,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
                'ownThreads' => $ownThreads,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMentions($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns target-authored posts and replies. Omit mode for automatic maximum coverage. Pass next_cursor unchanged. Unprefixed cursors stay legacy. Excludes other-author context.
     *
     * @param string $id target user ID or username for the replies timeline
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $imageShows Keep only posts whose photos show this. Send charts, screenshots, product_photos, memes or people, or describe it in words, such as a rocket. AI-powered analysis checks posts with photos X doesn't mark sensitive & keeps scores of 0.5 or more. Other posts stay out at no charge. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. imageFilter states the cutoff & counts.
     * @param bool $includeParentTweet include each reply's parent tweet
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $topic Keep only posts about this topic. AI-powered analysis asks "Is this post about <topic>?" of each post & keeps scores of 0.5 or more. It reads post text & safe photos. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. limit counts checked posts, & only kept posts come back. topicFilter states the cutoff & counts.
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Mode|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Mode>|null $mode Optional legacy pagination override. Filters such as keywords don't apply with it.
     * @param string|null $sinceTime Inclusive ISO bound for Tweet creation time, such as 2026-09-25T19:20:41Z. Unix seconds also work. A time without an offset is UTC.
     * @param string|null $untilTime Exclusive ISO bound for Tweet creation time. Unix seconds also work. A time without an offset is UTC.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $keywords words the Tweets must match, in X search syntax
     * @param string|null $listID search within a list ID
     * @param string|null $place search within a place ID
     * @param string|null $placeCountry search within a country code
     * @param string|null $pointRadius Geo point radius, such as -73.99 40.73 25mi.
     * @param string|null $boundingBox Geo bounding box, such as -74.1 40.6 -73.9 40.8.
     * @param string|null $advancedQuery raw advanced search query appended as-is
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveReplies(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $imageShows = null,
        bool $includeParentTweet = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $topic = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Mode|string|null $mode = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        ?int $minLikes = null,
        ?string $keywords = null,
        ?string $listID = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        ?string $boundingBox = null,
        ?string $advancedQuery = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'advancedQuery' => $advancedQuery, 'boundingBox' => $boundingBox, 'pointRadius' => $pointRadius, 'placeCountry' => $placeCountry, 'place' => $place, 'listID' => $listID, 'keywords' => $keywords, 'minLikes' => $minLikes, 'untilTime' => $untilTime, 'sinceTime' => $sinceTime, 'mode' => $mode,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'imageShows' => $imageShows,
                'includeParentTweet' => $includeParentTweet,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'topic' => $topic,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveReplies($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search users by name or username
     *
     * @param string $q User search query
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for user search
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
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param bool|null $enrichProfiles Add each row's full profile, as GET /x/users/{id} returns it. Pages take several seconds longer.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $q,
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
        ?int $pageSize = null,
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?bool $enrichProfiles = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'enrichProfiles' => $enrichProfiles, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly, 'pageSize' => $pageSize,
                'q' => $q,
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
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Omit mode for automatic maximum coverage. Pass next_cursor unchanged. Unprefixed cursors use legacy pagination. Shape and billing stay the same.
     *
     * @param string $id X user ID or username
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $imageShows Keep only posts whose photos show this. Send charts, screenshots, product_photos, memes or people, or describe it in words, such as a rocket. AI-powered analysis checks posts with photos X doesn't mark sensitive & keeps scores of 0.5 or more. Other posts stay out at no charge. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. imageFilter states the cutoff & counts.
     * @param bool $includeParentTweet Include parent tweet for replies
     * @param bool $includeReplies Include reply tweets
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $topic Keep only posts about this topic. AI-powered analysis asks "Is this post about <topic>?" of each post & keeps scores of 0.5 or more. It reads post text & safe photos. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. limit counts checked posts, & only kept posts come back. topicFilter states the cutoff & counts.
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Mode|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Mode>|null $mode Optional legacy pagination override. Filters such as keywords don't apply with it.
     * @param string|null $sinceTime Inclusive ISO bound for Tweet creation time, such as 2026-09-25T19:20:41Z. Unix seconds also work. A time without an offset is UTC.
     * @param string|null $untilTime Exclusive ISO bound for Tweet creation time. Unix seconds also work. A time without an offset is UTC.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $keywords words the Tweets must match, in X search syntax
     * @param string|null $listID search within a list ID
     * @param string|null $place search within a place ID
     * @param string|null $placeCountry search within a country code
     * @param string|null $pointRadius Geo point radius, such as -73.99 40.73 25mi.
     * @param string|null $boundingBox Geo bounding box, such as -74.1 40.6 -73.9 40.8.
     * @param string|null $advancedQuery raw advanced search query appended as-is
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $imageShows = null,
        bool $includeParentTweet = false,
        bool $includeReplies = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $topic = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Mode|string|null $mode = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        ?int $minLikes = null,
        ?string $keywords = null,
        ?string $listID = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        ?string $boundingBox = null,
        ?string $advancedQuery = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'advancedQuery' => $advancedQuery, 'boundingBox' => $boundingBox, 'pointRadius' => $pointRadius, 'placeCountry' => $placeCountry, 'place' => $place, 'listID' => $listID, 'keywords' => $keywords, 'minLikes' => $minLikes, 'untilTime' => $untilTime, 'sinceTime' => $sinceTime, 'mode' => $mode,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'imageShows' => $imageShows,
                'includeParentTweet' => $includeParentTweet,
                'includeReplies' => $includeReplies,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'topic' => $topic,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTweets($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List verified followers of a user
     *
     * @param string $id User ID or username for verified followers
     * @param string $after Legacy cursor alias. Prefer cursor.
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param int $limit Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams\Mode|value-of<\XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams\Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param int $pageSize Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param int|null $maxScan Most profiles 1 request reads, kept or dropped by the filters. The request then answers the profiles it kept, the count it dropped & the cursor to read on. Each request of a cursor may send its own value. Without it, a filtered read scans at most 100,000 profiles of the list across all its pages, & the page that reaches them ends the list with `scanLimit`. An unfiltered read has no scan limit. Automatic mode only.
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param bool|null $enrichProfiles Add each row's full profile, as GET /x/users/{id} returns it. Pages take several seconds longer.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        ?string $after = null,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?int $limit = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        \XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams\Mode|string|null $mode = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        ?int $maxScan = null,
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?bool $enrichProfiles = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers|\XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse\UserListCoverageResponse {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'enrichProfiles' => $enrichProfiles, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxScan' => $maxScan,
                'after' => $after,
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'limit' => $limit,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'mode' => $mode,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveVerifiedFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the newest posts of up to 20 users, named by user ID, username or profile link, in the order named. Send ids or usernames, not both. Each post costs 1 credit. A user in unavailable_ids or unprocessed_ids costs nothing.
     *
     * @param string|null $ids Comma-separated numeric user IDs (1-20 values). Xquik reads any other entry as a username, with or without @, so IDs and usernames can mix. Xquik ignores duplicates and keeps the first-seen order, IDs before usernames. A longer URL fails at the edge before Xquik reads it.
     * @param string|null $usernames Comma-separated X usernames, with or without @, or profile links such as x.com/nasa (1-20 values), in place of ids. A name in another case is the same account. A number is a user ID. A longer URL fails at the edge before Xquik reads it.
     * @param int|null $pageSize Posts per user (1-20, default 20). A low credit balance can return fewer. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveBatchTweets(
        ?string $ids = null,
        ?string $usernames = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): BatchUserTweets {
        $params = Util::removeNulls(
            [
                'ids' => $ids,
                'usernames' => $usernames,
                'pageSize' => $pageSize,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveBatchTweets(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Blocks a user through a connected X account. X removes follows both ways, and unblocking doesn't restore them.
     *
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function block(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): XWriteAction {
        $params = Util::removeNulls(
            [
                'account' => $account,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->block($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Unblocks a user through a connected X account.
     *
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unblock(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): XWriteAction {
        $params = Util::removeNulls(
            [
                'account' => $account,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->unblock($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Mutes a user through a connected X account. The user's posts leave that account's timelines, and X doesn't tell the user.
     *
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function mute(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): XWriteAction {
        $params = Util::removeNulls(
            [
                'account' => $account,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->mute($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Unmutes a user through a connected X account.
     *
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unmute(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): XWriteAction {
        $params = Util::removeNulls(
            [
                'account' => $account,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->unmute($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the accounts an organization lists as its affiliates, in X's order. An account without affiliates returns an empty list.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Profiles to request from this page (1-200, default 200). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param int|null $minFollowers Minimum follower count. Profiles the filter drops cost nothing.
     * @param int|null $maxFollowers Maximum follower count. A profile without a count passes.
     * @param int|null $minFollowing profiles must follow at least this many accounts
     * @param int|null $maxFollowing profiles may follow at most this many accounts
     * @param int|null $minStatuses Minimum post count. minPosts is also accepted.
     * @param int|null $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int|null $minAccountAgeDays minimum account age in whole days
     * @param bool|null $verifiedOnly only return verified profiles
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param string|null $verifiedType match the verification type exactly, ignoring case
     * @param bool|null $hasWebsite only return profiles with a website
     * @param bool|null $hasLocation only return profiles with a location
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param string|null $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string|null $locationContains match a location substring, ignoring case
     * @param string|null $usernameContains match a username substring, ignoring case
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveAffiliates(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?int $minFollowers = null,
        ?int $maxFollowers = null,
        ?int $minFollowing = null,
        ?int $maxFollowing = null,
        ?int $minStatuses = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?bool $verifiedOnly = null,
        ?bool $blueVerifiedOnly = null,
        ?string $verifiedType = null,
        ?bool $hasWebsite = null,
        ?bool $hasLocation = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?string $bioContains = null,
        ?string $locationContains = null,
        ?string $usernameContains = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'minFollowers' => $minFollowers,
                'maxFollowers' => $maxFollowers,
                'minFollowing' => $minFollowing,
                'maxFollowing' => $maxFollowing,
                'minStatuses' => $minStatuses,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'verifiedOnly' => $verifiedOnly,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'verifiedType' => $verifiedType,
                'hasWebsite' => $hasWebsite,
                'hasLocation' => $hasLocation,
                'hasEmail' => $hasEmail,
                'businessEmailOnly' => $businessEmailOnly,
                'emailDomains' => $emailDomains,
                'bioContains' => $bioContains,
                'locationContains' => $locationContains,
                'usernameContains' => $usernameContains,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveAffiliates($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the creators the selected user subscribes to, in X's order. An account that hides its subscriptions returns an empty list.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Profiles to request from this page (1-200, default 200). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param int|null $minFollowers Minimum follower count. Profiles the filter drops cost nothing.
     * @param int|null $maxFollowers Maximum follower count. A profile without a count passes.
     * @param int|null $minFollowing profiles must follow at least this many accounts
     * @param int|null $maxFollowing profiles may follow at most this many accounts
     * @param int|null $minStatuses Minimum post count. minPosts is also accepted.
     * @param int|null $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int|null $minAccountAgeDays minimum account age in whole days
     * @param bool|null $verifiedOnly only return verified profiles
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param string|null $verifiedType match the verification type exactly, ignoring case
     * @param bool|null $hasWebsite only return profiles with a website
     * @param bool|null $hasLocation only return profiles with a location
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param string|null $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string|null $locationContains match a location substring, ignoring case
     * @param string|null $usernameContains match a username substring, ignoring case
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSubscriptions(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?int $minFollowers = null,
        ?int $maxFollowers = null,
        ?int $minFollowing = null,
        ?int $maxFollowing = null,
        ?int $minStatuses = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?bool $verifiedOnly = null,
        ?bool $blueVerifiedOnly = null,
        ?string $verifiedType = null,
        ?bool $hasWebsite = null,
        ?bool $hasLocation = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?string $bioContains = null,
        ?string $locationContains = null,
        ?string $usernameContains = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'minFollowers' => $minFollowers,
                'maxFollowers' => $maxFollowers,
                'minFollowing' => $minFollowing,
                'maxFollowing' => $maxFollowing,
                'minStatuses' => $minStatuses,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'verifiedOnly' => $verifiedOnly,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'verifiedType' => $verifiedType,
                'hasWebsite' => $hasWebsite,
                'hasLocation' => $hasLocation,
                'hasEmail' => $hasEmail,
                'businessEmailOnly' => $businessEmailOnly,
                'emailDomains' => $emailDomains,
                'bioContains' => $bioContains,
                'locationContains' => $locationContains,
                'usernameContains' => $usernameContains,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSubscriptions($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the public X Lists the selected user created, in X's order, as the profile's Lists tab shows them. Each List costs 1 credit. A protected account answers 403.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLists(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedLists {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveLists($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the public X Lists that include the selected user, as the profile's List memberships page shows them. Each List costs 1 credit. A protected account answers 403.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveListMemberships(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedLists {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveListMemberships($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the posts on the user's Articles tab, newest first. Each post's `article` holds the Article's ID, title, preview, cover & dates. Read the full text with GET /x/articles/{tweetId}.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fromUser Filter by author username. Account searches include all of the account's posts & reposts.
     * @param string|null $toUser filter replies sent to a username
     * @param string|null $mentioning filter tweets mentioning a username
     * @param string|null $language Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     * @param string|null $sinceDate Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     * @param string|null $untilDate end date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count
     * @param \XTwitterScraper\X\Users\UserRetrieveArticlesParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveArticlesParams\MediaType>|null $mediaType Filter media. Its aliases are has_video & has_media.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param int|null $minRetweets minimum retweets threshold
     * @param int|null $minReplies minimum replies threshold
     * @param int|null $minQuotes minimum quote count threshold
     * @param int|null $minViews minimum view count threshold
     * @param int|null $minBookmarks minimum bookmark count threshold
     * @param int|null $maxFaves Maximum likes threshold. maxLikes & max_likes also work.
     * @param int|null $maxRetweets maximum retweets threshold
     * @param int|null $maxReplies maximum replies threshold
     * @param int|null $maxQuotes maximum quotes threshold
     * @param bool|null $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string|null $sinceID Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     * @param string|null $maxID return Tweets at or below this ID
     * @param string|null $withinTime Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     * @param bool|null $nativeRetweets only return native reposts
     * @param bool|null $verifiedOnly only return tweets from verified authors
     * @param \XTwitterScraper\X\Users\UserRetrieveArticlesParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveArticlesParams\Replies>|null $replies Reply mode. Exclude keeps own-thread replies.
     * @param \XTwitterScraper\X\Users\UserRetrieveArticlesParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveArticlesParams\Retweets>|null $retweets only when the caller requests a repost mode
     * @param \XTwitterScraper\X\Users\UserRetrieveArticlesParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveArticlesParams\Quotes>|null $quotes only when the caller requests a quote mode
     * @param string|null $exactPhrase match this exact phrase, word for word
     * @param string|null $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string|null $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string|null $hashtags hashtags separated by spaces, commas, or lines
     * @param string|null $cashtags cashtags separated by spaces, commas, or lines
     * @param string|null $url URL substring or domain filter
     * @param string|null $conversationID conversation ID filter
     * @param string|null $inReplyToTweetID only replies to this tweet ID
     * @param string|null $quotesOfTweetID only quotes of this tweet ID
     * @param string|null $retweetsOfTweetID only retweets of this tweet ID
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveArticles(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fromUser = null,
        ?string $toUser = null,
        ?string $mentioning = null,
        ?string $language = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        \XTwitterScraper\X\Users\UserRetrieveArticlesParams\MediaType|string|null $mediaType = null,
        ?int $minLikes = null,
        ?int $minRetweets = null,
        ?int $minReplies = null,
        ?int $minQuotes = null,
        ?int $minViews = null,
        ?int $minBookmarks = null,
        ?int $maxFaves = null,
        ?int $maxRetweets = null,
        ?int $maxReplies = null,
        ?int $maxQuotes = null,
        ?bool $blueVerifiedOnly = null,
        ?string $sinceID = null,
        ?string $maxID = null,
        ?string $withinTime = null,
        ?bool $nativeRetweets = null,
        ?bool $verifiedOnly = null,
        \XTwitterScraper\X\Users\UserRetrieveArticlesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveArticlesParams\Retweets|string|null $retweets = null,
        \XTwitterScraper\X\Users\UserRetrieveArticlesParams\Quotes|string|null $quotes = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $anyWords = null,
        ?string $hashtags = null,
        ?string $cashtags = null,
        ?string $url = null,
        ?string $conversationID = null,
        ?string $inReplyToTweetID = null,
        ?string $quotesOfTweetID = null,
        ?string $retweetsOfTweetID = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets2 {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fromUser' => $fromUser,
                'toUser' => $toUser,
                'mentioning' => $mentioning,
                'language' => $language,
                'sinceDate' => $sinceDate,
                'untilDate' => $untilDate,
                'mediaType' => $mediaType,
                'minLikes' => $minLikes,
                'minRetweets' => $minRetweets,
                'minReplies' => $minReplies,
                'minQuotes' => $minQuotes,
                'minViews' => $minViews,
                'minBookmarks' => $minBookmarks,
                'maxFaves' => $maxFaves,
                'maxRetweets' => $maxRetweets,
                'maxReplies' => $maxReplies,
                'maxQuotes' => $maxQuotes,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'sinceID' => $sinceID,
                'maxID' => $maxID,
                'withinTime' => $withinTime,
                'nativeRetweets' => $nativeRetweets,
                'verifiedOnly' => $verifiedOnly,
                'replies' => $replies,
                'retweets' => $retweets,
                'quotes' => $quotes,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'anyWords' => $anyWords,
                'hashtags' => $hashtags,
                'cashtags' => $cashtags,
                'url' => $url,
                'conversationID' => $conversationID,
                'inReplyToTweetID' => $inReplyToTweetID,
                'quotesOfTweetID' => $quotesOfTweetID,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveArticles($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the posts on the user's Highlights tab, in X's order. An account without highlights returns an empty list.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fromUser Filter by author username. Account searches include all of the account's posts & reposts.
     * @param string|null $toUser filter replies sent to a username
     * @param string|null $mentioning filter tweets mentioning a username
     * @param string|null $language Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     * @param string|null $sinceDate Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     * @param string|null $untilDate end date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count
     * @param \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveHighlightsParams\MediaType>|null $mediaType Filter media. Its aliases are has_video & has_media.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param int|null $minRetweets minimum retweets threshold
     * @param int|null $minReplies minimum replies threshold
     * @param int|null $minQuotes minimum quote count threshold
     * @param int|null $minViews minimum view count threshold
     * @param int|null $minBookmarks minimum bookmark count threshold
     * @param int|null $maxFaves Maximum likes threshold. maxLikes & max_likes also work.
     * @param int|null $maxRetweets maximum retweets threshold
     * @param int|null $maxReplies maximum replies threshold
     * @param int|null $maxQuotes maximum quotes threshold
     * @param bool|null $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string|null $sinceID Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     * @param string|null $maxID return Tweets at or below this ID
     * @param string|null $withinTime Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     * @param bool|null $nativeRetweets only return native reposts
     * @param bool|null $verifiedOnly only return tweets from verified authors
     * @param \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Replies>|null $replies Reply mode. Exclude keeps own-thread replies.
     * @param \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Retweets>|null $retweets only when the caller requests a repost mode
     * @param \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Quotes>|null $quotes only when the caller requests a quote mode
     * @param string|null $exactPhrase match this exact phrase, word for word
     * @param string|null $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string|null $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string|null $hashtags hashtags separated by spaces, commas, or lines
     * @param string|null $cashtags cashtags separated by spaces, commas, or lines
     * @param string|null $url URL substring or domain filter
     * @param string|null $conversationID conversation ID filter
     * @param string|null $inReplyToTweetID only replies to this tweet ID
     * @param string|null $quotesOfTweetID only quotes of this tweet ID
     * @param string|null $retweetsOfTweetID only retweets of this tweet ID
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveHighlights(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fromUser = null,
        ?string $toUser = null,
        ?string $mentioning = null,
        ?string $language = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\MediaType|string|null $mediaType = null,
        ?int $minLikes = null,
        ?int $minRetweets = null,
        ?int $minReplies = null,
        ?int $minQuotes = null,
        ?int $minViews = null,
        ?int $minBookmarks = null,
        ?int $maxFaves = null,
        ?int $maxRetweets = null,
        ?int $maxReplies = null,
        ?int $maxQuotes = null,
        ?bool $blueVerifiedOnly = null,
        ?string $sinceID = null,
        ?string $maxID = null,
        ?string $withinTime = null,
        ?bool $nativeRetweets = null,
        ?bool $verifiedOnly = null,
        \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Retweets|string|null $retweets = null,
        \XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Quotes|string|null $quotes = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $anyWords = null,
        ?string $hashtags = null,
        ?string $cashtags = null,
        ?string $url = null,
        ?string $conversationID = null,
        ?string $inReplyToTweetID = null,
        ?string $quotesOfTweetID = null,
        ?string $retweetsOfTweetID = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets2 {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fromUser' => $fromUser,
                'toUser' => $toUser,
                'mentioning' => $mentioning,
                'language' => $language,
                'sinceDate' => $sinceDate,
                'untilDate' => $untilDate,
                'mediaType' => $mediaType,
                'minLikes' => $minLikes,
                'minRetweets' => $minRetweets,
                'minReplies' => $minReplies,
                'minQuotes' => $minQuotes,
                'minViews' => $minViews,
                'minBookmarks' => $minBookmarks,
                'maxFaves' => $maxFaves,
                'maxRetweets' => $maxRetweets,
                'maxReplies' => $maxReplies,
                'maxQuotes' => $maxQuotes,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'sinceID' => $sinceID,
                'maxID' => $maxID,
                'withinTime' => $withinTime,
                'nativeRetweets' => $nativeRetweets,
                'verifiedOnly' => $verifiedOnly,
                'replies' => $replies,
                'retweets' => $retweets,
                'quotes' => $quotes,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'anyWords' => $anyWords,
                'hashtags' => $hashtags,
                'cashtags' => $cashtags,
                'url' => $url,
                'conversationID' => $conversationID,
                'inReplyToTweetID' => $inReplyToTweetID,
                'quotesOfTweetID' => $quotesOfTweetID,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveHighlights($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the public accounts X lists as similar to the selected user, in X's order. Each account costs 1 credit.
     *
     * Similar-account lists come back fuller.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Profiles to request from this page (1-200, default 200). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param int|null $minFollowers Minimum follower count. Profiles the filter drops cost nothing.
     * @param int|null $maxFollowers Maximum follower count. A profile without a count passes.
     * @param int|null $minFollowing profiles must follow at least this many accounts
     * @param int|null $maxFollowing profiles may follow at most this many accounts
     * @param int|null $minStatuses Minimum post count. minPosts is also accepted.
     * @param int|null $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int|null $minAccountAgeDays minimum account age in whole days
     * @param bool|null $verifiedOnly only return verified profiles
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param string|null $verifiedType match the verification type exactly, ignoring case
     * @param bool|null $hasWebsite only return profiles with a website
     * @param bool|null $hasLocation only return profiles with a location
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param string|null $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string|null $locationContains match a location substring, ignoring case
     * @param string|null $usernameContains match a username substring, ignoring case
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSimilar(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?int $minFollowers = null,
        ?int $maxFollowers = null,
        ?int $minFollowing = null,
        ?int $maxFollowing = null,
        ?int $minStatuses = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?bool $verifiedOnly = null,
        ?bool $blueVerifiedOnly = null,
        ?string $verifiedType = null,
        ?bool $hasWebsite = null,
        ?bool $hasLocation = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?string $bioContains = null,
        ?string $locationContains = null,
        ?string $usernameContains = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'minFollowers' => $minFollowers,
                'maxFollowers' => $maxFollowers,
                'minFollowing' => $minFollowing,
                'maxFollowing' => $maxFollowing,
                'minStatuses' => $minStatuses,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'verifiedOnly' => $verifiedOnly,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'verifiedType' => $verifiedType,
                'hasWebsite' => $hasWebsite,
                'hasLocation' => $hasLocation,
                'hasEmail' => $hasEmail,
                'businessEmailOnly' => $businessEmailOnly,
                'emailDomains' => $emailDomains,
                'bioContains' => $bioContains,
                'locationContains' => $locationContains,
                'usernameContains' => $usernameContains,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSimilar($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns X's own translation of 1 profile's bio into the language you pick, with the links, mentions, and tags X places in the translated text. A profile without a bio returns translation null & a message, free of charge.
     *
     * Posts & bios can be translated into your language.
     *
     * @param string $language Language code to translate into, such as `es`, `tr`, `pt-br`, or `zh-tw`. Upper and lower case both work.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function translateBio(
        string $id,
        string $language,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserTranslateBioResponse {
        $params = Util::removeNulls(
            [
                'language' => $language,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->translateBio($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Reads the newest followers of a public account & returns a follower audit. It gives each follower 1 class with its score & signals, then adds coverage, a quality score, signal counts, arrival bands, join cohorts, countries, top followers & the account's engagement. Each follower read costs 1 credit, and the engagement adds 1 credit. Signals come from public profiles, so a real person can match. Older followers may differ from the newest ones.
     *
     * @param int|null $limit Most followers to read, newest first. Left out, a read takes up to 200 and a low balance reads fewer. A very long read returns what it finished, & coverage shows how many. Its aliases are pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowerAudit(
        string $id,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserRetrieveFollowerAuditResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowerAudit($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns engagement insights for 1 profile. They are engagement rate, averages per post and posting rate, from its counts and its most recent posts. It reads 20 posts unless limit names another number. Reposts and the pinned post stay out of the averages. Each report costs 1 credit, whatever it reads.
     *
     * @param int|null $limit Recent posts to read for the averages and rates. The read stops at this count, at the account's oldest post or after about 40 seconds. `sample.read` says how many it read, and `sample.posts` how many of those the averages used. `pageSize`, `count`, `max_results`, `maxItems`, `max_items` & `per_page` are accepted aliases.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveInsights(
        string $id,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserRetrieveInsightsResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveInsights($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Says whether 1 user is broadcasting live video on X right now, with their latest broadcast, live or ended. Each check costs 1 credit.
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLive(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): UserLiveStatus {
        $params = Util::removeNulls(
            [
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveLive($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Checks 1 X account for a search ban, a search suggestion ban, reply deboosting & a reply lock. It also tests timeline visibility & early engagement, reads the sensitive flag & the countries that withhold the account, and says if the account is active, protected or suspended.
     *
     * Each check answers pass, fail or unknown, with its reason & what it read. `overall` sums up the checks, and `checkedAt` holds the time of the check. The reply checks and the engagement check answer pass or unknown, since X ranks replies for each viewer and a drop alone proves nothing. A protected account skips the checks that need public posts, and a suspended account gets the account check only. Each profile, post, suggestion & reply in the answer costs 1 credit.
     *
     * The timeline, engagement & reply checks read the account's 20 most recent posts unless `limit` names another number.
     *
     * Shadowban checks show if X search lists an account, with each post they read.
     *
     * @param int|null $limit Recent posts to read for the timeline, engagement & reply checks. The read stops at this count, at the account's oldest post or after about 40 seconds. `pageSize`, `count`, `max_results`, `maxItems`, `max_items` & `per_page` are accepted aliases.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveShadowban(
        string $id,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): ShadowbanReport {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveShadowban($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the user IDs of the selected user's followers, newest first, up to 5,000 a page. Use it when you need IDs only. Each ID costs 1 credit.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize User IDs to request from this page (1-5000, default 5000). A low credit balance can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowerIds(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUserIDs {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowerIds($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the user IDs of the accounts the selected user follows, newest first, up to 5,000 a page. Use it when you need IDs only. Each ID costs 1 credit.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize User IDs to request from this page (1-5000, default 5000). A low credit balance can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowingIds(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUserIDs {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowingIds($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
