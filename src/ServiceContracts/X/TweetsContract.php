<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\MediaType;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Quotes;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Replies;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Retweets;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface TweetsContract
{
    /**
     * @api
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
    ): TweetNewResponse;

    /**
     * @api
     *
     * @param string $id Numeric tweet ID, 15-20 digits
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): TweetGetResponse;

    /**
     * @api
     *
     * @param string $ids Comma-separated tweet IDs (max 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $ids,
        RequestOptions|array|null $requestOptions = null
    ): PaginatedTweets;

    /**
     * @api
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
    ): TweetDeleteResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to get favoriters
     * @param string $cursor Pagination cursor for favoriters
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getFavoriters(
        string $id,
        ?string $cursor = null,
        int $pageSize = 200,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers;

    /**
     * @api
     *
     * @param string $id Numeric tweet ID to get quotes, 15-20 digits
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for quote tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $includeReplies Include reply quotes (default false)
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param MediaType|value-of<MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param Quotes|value-of<Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param Replies|value-of<Replies> $replies reply mode
     * @param Retweets|value-of<Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceTime Unix timestamp - return quotes posted after this time
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return quotes posted before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getQuotes(
        string $id,
        ?string $anyWords = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?bool $includeReplies = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        int $pageSize = 20,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $sinceTime = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $id Tweet ID to get replies
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for tweet replies
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceTime Unix timestamp - return replies posted after this time
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return replies posted before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getReplies(
        string $id,
        ?string $anyWords = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $sinceTime = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $id Tweet ID to get retweeters
     * @param string $cursor Pagination cursor for retweeters
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getRetweeters(
        string $id,
        ?string $cursor = null,
        int $pageSize = 200,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers;

    /**
     * @api
     *
     * @param string $id Tweet ID to get thread context
     * @param string $cursor Pagination cursor for thread tweets
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getThread(
        string $id,
        ?string $cursor = null,
        int $pageSize = 20,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $q Search query (keywords,
     * @param string $advancedQuery raw advanced search query appended as-is
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string $boundingBox Geo bounding box, e.g. -74.1 40.6 -73.9 40.8.
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor from previous response
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $limit Max tweets to return (server paginates internally). Omit for single page (~20). This is an upper bound for paid authenticated calls: remaining credits can reduce the returned page size, and zero affordable results returns 402 insufficient_credits.
     * @param string $listID search within a list ID
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param string $place search within a place ID
     * @param string $placeCountry search within a country code
     * @param string $pointRadius Geo point radius, e.g. -73.99 40.73 25mi.
     * @param QueryType|value-of<QueryType> $queryType Sort order - Latest (chronological) or Top (engagement-ranked)
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceTime ISO 8601 timestamp - only return tweets after this time
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime ISO 8601 timestamp - only return tweets before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function search(
        string $q,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $boundingBox = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        int $limit = 20,
        ?string $listID = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        QueryType|string $queryType = 'Latest',
        \XTwitterScraper\X\Tweets\TweetSearchParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $sinceTime = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;
}
