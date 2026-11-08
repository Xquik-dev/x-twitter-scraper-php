<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\CommunityAnalytics;
use XTwitterScraper\CommunityPage;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityListSuggestedResponse;
use XTwitterScraper\X\Communities\CommunityListTopicsResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\MediaType;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\QueryType;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\Quotes;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\Replies;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\Retweets;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface CommunitiesContract
{
    /**
     * @api
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
    ): CommunityNewResponse;

    /**
     * @api
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
    ): CommunityDeleteResponse;

    /**
     * @api
     *
     * @param string $id Community ID
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveInfo(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null
    ): CommunityGetInfoResponse;

    /**
     * @api
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
     * @param string $communityID Numeric ID of the community whose posts to search
     * @param string $q Search query
     * @param string $cursor Pagination cursor for community search
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param QueryType|value-of<QueryType> $queryType Sort order (Latest or Top)
     * @param string|null $language Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     * @param string|null $fromUser Filter by author username. Account searches include all of the account's posts & reposts.
     * @param string|null $toUser filter replies sent to a username
     * @param string|null $mentioning filter tweets mentioning a username
     * @param string|null $sinceDate Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     * @param string|null $untilDate end date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count
     * @param string|null $withinTime Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     * @param MediaType|value-of<MediaType>|null $mediaType Filter media. Its aliases are has_video & has_media.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param int|null $minRetweets minimum retweets threshold
     * @param int|null $minReplies minimum replies threshold
     * @param int|null $minViews minimum view count threshold
     * @param int|null $minQuotes minimum quote count threshold
     * @param int|null $minBookmarks minimum bookmark count threshold
     * @param int|null $maxFaves Maximum likes threshold. maxLikes & max_likes also work.
     * @param int|null $maxRetweets maximum retweets threshold
     * @param int|null $maxReplies maximum replies threshold
     * @param int|null $maxQuotes maximum quotes threshold
     * @param bool|null $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string|null $sinceID Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     * @param string|null $maxID return Tweets at or below this ID
     * @param bool|null $nativeRetweets only return native reposts
     * @param bool|null $verifiedOnly only return tweets from verified authors
     * @param Replies|value-of<Replies>|null $replies Reply mode. Exclude keeps own-thread replies.
     * @param Retweets|value-of<Retweets>|null $retweets only when the caller requests a repost mode
     * @param Quotes|value-of<Quotes>|null $quotes only when the caller requests a quote mode
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
    public function retrieveSearch(
        string $communityID,
        string $q,
        ?string $cursor = null,
        int $pageSize = 20,
        QueryType|string $queryType = 'Latest',
        ?string $language = null,
        ?string $fromUser = null,
        ?string $toUser = null,
        ?string $mentioning = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        ?string $withinTime = null,
        MediaType|string|null $mediaType = null,
        ?int $minLikes = null,
        ?int $minRetweets = null,
        ?int $minReplies = null,
        ?int $minViews = null,
        ?int $minQuotes = null,
        ?int $minBookmarks = null,
        ?int $maxFaves = null,
        ?int $maxRetweets = null,
        ?int $maxReplies = null,
        ?int $maxQuotes = null,
        ?bool $blueVerifiedOnly = null,
        ?string $sinceID = null,
        ?string $maxID = null,
        ?bool $nativeRetweets = null,
        ?bool $verifiedOnly = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        Quotes|string|null $quotes = null,
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
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveAnalytics(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityAnalytics;

    /**
     * @api
     *
     * @param string $q Name or username to find members by, such as marckohlbrugge. A leading @ is dropped. Alias query. Xquik's cap is 4,096 characters.
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
    public function searchMembers(
        string $id,
        string $q,
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
     * @param string $q Keyword to find communities by, such as ai. Alias query. Xquik's cap is 4,096 characters.
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function find(
        string $q,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityPage;

    /**
     * @api
     *
     * @param string|null $topicID Topic or subtopic ID from /x/communities/topics, such as 301. Wins over topic. X can add topics, so Xquik takes up to 280 characters, the most a post holds.
     * @param string|null $topic Topic or subtopic name in any case, such as technology. Send this or topicId. X can add topics, so Xquik takes up to 280 characters, the most a post holds.
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listPopular(
        ?string $topicID = null,
        ?string $topic = null,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityPage;

    /**
     * @api
     *
     * @param int|null $limit Maximum topics to return. Omit it for every topic. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listTopics(
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityListTopicsResponse;

    /**
     * @api
     *
     * @param int|null $limit Maximum communities to return. Omit it for every suggestion. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listSuggested(
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityListSuggestedResponse;
}
