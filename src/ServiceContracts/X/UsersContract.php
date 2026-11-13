<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\BatchUserTweets;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedLists;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
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
interface UsersContract
{
    /**
     * @api
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
    ): UserProfile;

    /**
     * @api
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
    ): UserRemoveFollowerResponse;

    /**
     * @api
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
    ): UserGetBatchResponse;

    /**
     * @api
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
    ): PaginatedUsers|UserListCoverageResponse;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedUsers|\XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedTweets;

    /**
     * @api
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
    ): PaginatedUsers|\XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse\UserListCoverageResponse;

    /**
     * @api
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
    ): BatchUserTweets;

    /**
     * @api
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
    ): XWriteAction;

    /**
     * @api
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
    ): XWriteAction;

    /**
     * @api
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
    ): XWriteAction;

    /**
     * @api
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
    ): XWriteAction;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedLists;

    /**
     * @api
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
    ): PaginatedLists;

    /**
     * @api
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
    ): PaginatedTweets2;

    /**
     * @api
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
    ): PaginatedTweets2;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): UserTranslateBioResponse;

    /**
     * @api
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
    ): UserRetrieveFollowerAuditResponse;

    /**
     * @api
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
    ): UserRetrieveInsightsResponse;

    /**
     * @api
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
    ): UserLiveStatus;

    /**
     * @api
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
    ): ShadowbanReport;

    /**
     * @api
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
    ): PaginatedUserIDs;

    /**
     * @api
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
    ): PaginatedUserIDs;
}
