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
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\TweetsContract;
use XTwitterScraper\Services\X\Tweets\LikeService;
use XTwitterScraper\Services\X\Tweets\RetweetService;
use XTwitterScraper\X\Tweets\TweetCheckRepostResponse;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetEmbedParams\Theme;
use XTwitterScraper\X\Tweets\TweetEmbedResponse;
use XTwitterScraper\X\Tweets\TweetGetInsightsResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\MediaType;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Quotes;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Replies;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Retweets;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Mode;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Scope;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Sort;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetGetSubtitlesResponse;
use XTwitterScraper\X\Tweets\TweetListTopParams\Metric;
use XTwitterScraper\X\Tweets\TweetListTopParams\Window;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetResolveLinksResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse;
use XTwitterScraper\X\Tweets\TweetTranslateResponse;
use XTwitterScraper\XWriteAction;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class TweetsService implements TweetsContract
{
    /**
     * @api
     */
    public TweetsRawService $raw;

    /**
     * @api
     */
    public LikeService $like;

    /**
     * @api
     */
    public RetweetService $retweet;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TweetsRawService($client);
        $this->like = new LikeService($client);
        $this->retweet = new RetweetService($client);
    }

    /**
     * @api
     *
     * Create tweet
     *
     * @param string $account Body param: X account (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param string $communityID Body param
     * @param bool $isNoteTweet Body param
     * @param list<string> $media Body param: Array of public media URLs to attach. Supports up to 4 images or exactly 1 MP4 video up to 100 MB. Each URL must be publicly reachable. Attached media adds 2 credits per started MB across all files.
     * @param string $replyToTweetID Body param
     * @param string $text Body param: Tweet text (optional when media is provided)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $account,
        string $idempotencyKey,
        ?string $communityID = null,
        ?bool $isNoteTweet = null,
        ?array $media = null,
        ?string $replyToTweetID = null,
        ?string $text = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetNewResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'idempotencyKey' => $idempotencyKey,
                'communityID' => $communityID,
                'isNoteTweet' => $isNoteTweet,
                'media' => $media,
                'replyToTweetID' => $replyToTweetID,
                'text' => $text,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get tweet with full text, author, metrics and media
     *
     * @param string $id Numeric tweet ID, 15-20 digits
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
    ): TweetGetResponse {
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
     * Get multiple tweets by IDs
     *
     * @param string $ids Comma-separated tweet IDs (max 100)
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $ids,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null
    ): PaginatedTweets {
        $params = Util::removeNulls(['omit' => $omit, 'fields' => $fields, 'ids' => $ids]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete tweet
     *
     * @param string $id Path param: Tweet ID to delete
     * @param string $account Body param: X account identifier (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $account,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): TweetDeleteResponse {
        $params = Util::removeNulls(
            ['account' => $account, 'idempotencyKey' => $idempotencyKey]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns liker profiles that X makes visible for the post. X can withhold liker identities even when the post reports likes. In that case this endpoint returns 424 `favoriters_unavailable` instead of a misleading empty success.
     *
     * @param string $id Tweet ID to get favoriters
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for favoriters
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
    public function getFavoriters(
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
        $response = $this->raw->getFavoriters($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List quote tweets of a tweet
     *
     * @param string $id Numeric tweet ID to get quotes, 15-20 digits
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for quote tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $includeReplies Include reply quotes (default false)
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
     * @param string $sinceTime Unix timestamp - return quotes posted after this time
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return quotes posted before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param \XTwitterScraper\X\Tweets\TweetGetQuotesParams\Mode|value-of<\XTwitterScraper\X\Tweets\TweetGetQuotesParams\Mode>|null $mode Optional legacy pagination override. Filters such as keywords don't apply with it.
     * @param \XTwitterScraper\X\Tweets\TweetGetQuotesParams\QueryType|value-of<\XTwitterScraper\X\Tweets\TweetGetQuotesParams\QueryType>|null $queryType Latest for newest first, or Top for the quotes X ranks highest. A later Latest page can hold a newer quote. Top is X's ranking, not a count order, & a later page can hold a quote X ranks higher. Any case works. Alias sort, which also takes Recency & Relevance. Send the same value with each cursor. Standard pages list Latest.
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
    public function getQuotes(
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
        ?bool $includeReplies = null,
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
        ?string $sinceTime = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        \XTwitterScraper\X\Tweets\TweetGetQuotesParams\Mode|string|null $mode = null,
        \XTwitterScraper\X\Tweets\TweetGetQuotesParams\QueryType|string|null $queryType = null,
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
            ['omit' => $omit, 'fields' => $fields, 'advancedQuery' => $advancedQuery, 'boundingBox' => $boundingBox, 'pointRadius' => $pointRadius, 'placeCountry' => $placeCountry, 'place' => $place, 'listID' => $listID, 'keywords' => $keywords, 'minLikes' => $minLikes, 'queryType' => $queryType, 'mode' => $mode,
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
                'sinceTime' => $sinceTime,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getQuotes($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns direct replies. Omit mode for automatic maximum coverage with resumable pagination. Complete mode returns nested replies, diagnostics, and 424 when direct coverage stays below 80%.
     *
     * @param string $id Tweet ID to get replies
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param string $exactPhrase exact phrase to match
     * @param bool $excludeOriginalAuthor exclude replies written by the source-post author
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $hasMediaOnly only return replies containing media
     * @param bool $includeOriginalPost include the source post and count it toward limit
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $limit With mode=complete, maximum combined direct and nested reply rows (1-25000, default 25000). Automatic pages accept 1-300. Standard pages accept 1-100. Prefer pageSize outside complete mode.
     * @param int $maxDepth maximum reply depth from the source post
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param Mode|value-of<Mode> $mode Optional advanced override. Omit mode for automatic maximum direct reply coverage with pagination. Standard keeps legacy pagination. Complete returns direct and nested replies with diagnostics, scope, depth, sorting, and original-post controls.
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param Scope|value-of<Scope> $scope select all replies, direct replies, or nested replies
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $sinceTime Unix timestamp - return replies posted after this time
     * @param Sort|value-of<Sort> $sort sort the selected replies before applying limit
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return replies posted before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param string|null $after Legacy cursor alias. Prefer cursor.
     * @param bool|null $includeHidden Complete mode only. Adds the replies the post's author hid, each with hiddenByAuthor true. They count toward limit like any reply. A paged read answers 400. Get its hidden replies from GET /x/tweets/{id}/hidden-replies.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getReplies(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        bool $excludeOriginalAuthor = false,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        bool $hasMediaOnly = false,
        bool $includeOriginalPost = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $limit = null,
        ?int $maxDepth = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        Mode|string|null $mode = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        Scope|string $scope = 'all',
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $sinceTime = null,
        Sort|string $sort = 'relevance',
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        ?string $after = null,
        ?bool $includeHidden = null,
        ?int $minLikes = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetGetRepliesResponse {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'minLikes' => $minLikes, 'includeHidden' => $includeHidden, 'after' => $after,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeOriginalAuthor' => $excludeOriginalAuthor,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'hasMediaOnly' => $hasMediaOnly,
                'includeOriginalPost' => $includeOriginalPost,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'limit' => $limit,
                'maxDepth' => $maxDepth,
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
                'mode' => $mode,
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
                'scope' => $scope,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'sinceTime' => $sinceTime,
                'sort' => $sort,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getReplies($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List users who retweeted a tweet
     *
     * @param string $id Tweet ID to get retweeters
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for retweeters
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
     * @param bool|null $includeRetweetTimestamp look up repost event times
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
    public function getRetweeters(
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
        ?bool $includeRetweetTimestamp = null,
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
            ['omit' => $omit, 'fields' => $fields, 'enrichProfiles' => $enrichProfiles, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly, 'includeRetweetTimestamp' => $includeRetweetTimestamp,
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
        $response = $this->raw->getRetweeters($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get full conversation thread for a tweet
     *
     * @param string $id Tweet ID to get thread context
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for thread tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $sinceID Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     * @param string|null $maxID return Tweets at or below this ID
     * @param string|null $withinTime Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     * @param bool|null $nativeRetweets only return native reposts
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getThread(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?int $minLikes = null,
        ?string $sinceID = null,
        ?string $maxID = null,
        ?string $withinTime = null,
        ?bool $nativeRetweets = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'nativeRetweets' => $nativeRetweets, 'withinTime' => $withinTime, 'maxID' => $maxID, 'sinceID' => $sinceID, 'minLikes' => $minLikes,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
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
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'sinceDate' => $sinceDate,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getThread($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * No-mode search maximizes coverage. New cursorless `Latest` sessions return rows newest-first across cursor pages. Existing cursors preserve their established ordering.
     *
     * @param string $q Query, Tweet ID, or status URL. Valid inline bounds apply per page.
     * @param string $advancedQuery raw advanced search query appended as-is
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $boundingBox Geo bounding box, e.g. -74.1 40.6 -73.9 40.8.
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
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $limit Result upper bound. Omit it for the existing 20-row page size. Explicit coverage defaults to 2000 and allows 10000. For paid requests, remaining credits can reduce results. Zero affordable results returns 402.
     * @param string $listID search within a list ID
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Mode|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param string $place search within a place ID
     * @param string $placeCountry search within a country code
     * @param string $pointRadius Geo point radius, e.g. -73.99 40.73 25mi.
     * @param QueryType|value-of<QueryType> $queryType Sort order - Latest (chronological) or Top (engagement-ranked)
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $sinceTime inclusive ISO bound
     * @param string $source match the source application
     * @param string $topic Keep only posts about this topic. AI-powered analysis asks "Is this post about <topic>?" of each post & keeps scores of 0.5 or more. It reads post text & safe photos. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. limit counts checked posts, & only kept posts come back. topicFilter states the cutoff & counts.
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime exclusive ISO bound
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param string|null $textOnlyTerms keeps a post only when at least 1 of these words or quoted phrases appears outside the author's name and username, such as in its text, a link, its card or a quoted post
     * @param string|null $keywords words the Tweets must match, in X search syntax
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function search(
        string $q,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $boundingBox = null,
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
        ?int $limit = null,
        ?string $listID = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Mode|string|null $mode = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        QueryType|string $queryType = 'Latest',
        \XTwitterScraper\X\Tweets\TweetSearchParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $sinceTime = null,
        ?string $source = null,
        ?string $topic = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        ?int $minLikes = null,
        ?string $textOnlyTerms = null,
        ?string $keywords = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets|TweetSearchCoverageResponse {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'keywords' => $keywords, 'textOnlyTerms' => $textOnlyTerms, 'minLikes' => $minLikes,
                'q' => $q,
                'advancedQuery' => $advancedQuery,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'boundingBox' => $boundingBox,
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
                'limit' => $limit,
                'listID' => $listID,
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
                'mode' => $mode,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'place' => $place,
                'placeCountry' => $placeCountry,
                'pointRadius' => $pointRadius,
                'queryType' => $queryType,
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
                'topic' => $topic,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->search(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the tweets X ranks highest by 1 metric over the last day, week or month. Covers all of X unless you pick a country or a language. Pages hold up to 20 tweets, and the list ends at 100. Each tweet costs 1 credit.
     *
     * Top tweet lists come back reliably.
     *
     * @param Metric|value-of<Metric>|null $metric What to rank tweets by. Defaults to likes. Singular names work too, such as like.
     * @param Window|value-of<Window>|null $window How far back to look. Defaults to day. Also takes 24h, 7d, 30d, daily, weekly and monthly.
     * @param string|null $country Only tweets from 1 country, as a 2- or 3-letter ISO 3166 code, such as US or USA. Send country or language, not both.
     * @param string|null $language Only tweets in 1 language, as a 2-letter code, such as en. Send country or language, not both.
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listTop(
        Metric|string|null $metric = null,
        Window|string|null $window = null,
        ?string $country = null,
        ?string $language = null,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets2 {
        $params = Util::removeNulls(
            [
                'metric' => $metric,
                'window' => $window,
                'country' => $country,
                'language' => $language,
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listTop(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Bookmarks a post through a connected X account. Only that account sees its bookmarks, and GET /x/bookmarks lists them.
     *
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function bookmark(
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
        $response = $this->raw->bookmark($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Removes a bookmark through a connected X account.
     *
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function unbookmark(
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
        $response = $this->raw->unbookmark($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns whether 1 account reposted the post. It finds recent reposts. An older repost can return false, with complete false. Each check costs 1 credit.
     *
     * @param string $user user ID, username with or without @, or profile URL
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function checkRepost(
        string $id,
        string $user,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetCheckRepostResponse {
        $params = Util::removeNulls(
            [
                'user' => $user,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->checkRepost($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the user IDs of a post's reposters, in the order & pages of /x/tweets/{id}/retweeters. Use it when you need IDs only. Each ID costs 1 credit. A post nobody reposted returns an empty list for free.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Profiles to request from this page (1-200, default 200). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getRetweeterIds(
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
        $response = $this->raw->getRetweeterIds($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the replies the post's author hid, oldest first, with the replies to them. A post without hidden replies returns an empty list.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fromUser Filter by author username. Account searches include all of the account's posts & reposts.
     * @param string|null $toUser filter replies sent to a username
     * @param string|null $mentioning filter tweets mentioning a username
     * @param string|null $language Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     * @param string|null $sinceDate Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     * @param string|null $untilDate end date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count
     * @param \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\MediaType>|null $mediaType Filter media. Its aliases are has_video & has_media.
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
     * @param \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Replies>|null $replies Reply mode. Exclude keeps own-thread replies.
     * @param \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Retweets>|null $retweets only when the caller requests a repost mode
     * @param \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Quotes>|null $quotes only when the caller requests a quote mode
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
    public function getHiddenReplies(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fromUser = null,
        ?string $toUser = null,
        ?string $mentioning = null,
        ?string $language = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\MediaType|string|null $mediaType = null,
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
        \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Retweets|string|null $retweets = null,
        \XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams\Quotes|string|null $quotes = null,
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
        $response = $this->raw->getHiddenReplies($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns X's own translation of 1 public tweet into the language you pick, with the links, mentions, and tags X places in the translated text.
     *
     * Posts & bios can be translated into your language.
     *
     * @param string $language Language code to translate into, such as `en`, `tr`, `pt-br`, or `zh-tw`. Upper and lower case both work.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function translate(
        string $id,
        string $language,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetTranslateResponse {
        $params = Util::removeNulls(
            [
                'language' => $language,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->translate($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns engagement insights for 1 tweet. They are engagements per hour since it went up, per view and per follower of its author, and how far it spread. Each report costs 1 credit, whatever it reads.
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getInsights(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetGetInsightsResponse {
        $params = Util::removeNulls(
            [
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getInsights($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the HTML that X gives websites to embed 1 public tweet, with the tweet's link and author.
     *
     * @param Theme|value-of<Theme>|null $theme Color theme of the embed. X uses light when left out.
     * @param bool|null $hideMedia set `true` to leave photos, videos, and link cards out
     * @param bool|null $hideThread set `true` to leave the tweet this one replies to out
     * @param bool|null $omitScript set `true` to leave the widget script tag out, for pages that load it once themselves
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function embed(
        string $id,
        Theme|string|null $theme = null,
        ?bool $hideMedia = null,
        ?bool $hideThread = null,
        ?bool $omitScript = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetEmbedResponse {
        $params = Util::removeNulls(
            [
                'theme' => $theme,
                'hideMedia' => $hideMedia,
                'hideThread' => $hideThread,
                'omitScript' => $omitScript,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->embed($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the caption tracks of 1 public tweet's videos. Each track has its language, name, timed cues, and full text. A tweet without video, or a video without captions, returns no track and costs nothing.
     *
     * Video subtitles come with timed cues.
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getSubtitles(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetGetSubtitlesResponse {
        $params = Util::removeNulls(
            [
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getSubtitles($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns where each t.co link leads, as X's own redirect says. Xquik reads the redirect and never visits the target site. A link t.co does not have comes back without `resolvedUrl` and costs nothing. A link X does not answer for in time comes back in `unprocessedUrls`, free. Each resolved link costs 1 credit.
     *
     * @param string $urls 1 to 100 links of the form `https://t.co/Xe1nm2pkSX`, separated by commas. Any other link is refused. A link sent twice counts once. A longer URL fails at the edge before Xquik reads it.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function resolveLinks(
        string $urls,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetResolveLinksResponse {
        $params = Util::removeNulls(
            [
                'urls' => $urls,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->resolveLinks(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
