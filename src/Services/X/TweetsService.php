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
use XTwitterScraper\ServiceContracts\X\TweetsContract;
use XTwitterScraper\Services\X\Tweets\LikeService;
use XTwitterScraper\Services\X\Tweets\RetweetService;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\MediaType;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Quotes;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Replies;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Retweets;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Mode;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): TweetGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get multiple tweets by IDs
     *
     * @param string $ids Comma-separated tweet IDs (max 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $ids,
        RequestOptions|array|null $requestOptions = null
    ): PaginatedTweets {
        $params = Util::removeNulls(['ids' => $ids]);

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
    ): PaginatedUsers {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

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
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
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
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'includeReplies' => $includeReplies,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'sinceDate' => $sinceDate,
                'sinceTime' => $sinceTime,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getQuotes($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns direct replies. Complete mode merges available timeline views, supported rankings, every forward cursor module, labeled hidden-content branches, exact-parent time partitions scaled to the reported reply count, and search. It separates nested replies and returns 424 below 80% coverage.
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
     * @param int $limit With mode=complete, maximum combined direct and nested reply rows (1-25000). Without complete mode, this is the deprecated pageSize alias and uses the normal 1-100 page range.
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param Mode|value-of<Mode> $mode Set complete for maximum-coverage collection. Complete mode accepts only limit. Remove cursor, pageSize, count, time ranges, and tweet filters.
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
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
        int $limit = 25000,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        Mode|string|null $mode = null,
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
    ): TweetGetRepliesResponse {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'limit' => $limit,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'mode' => $mode,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'sinceDate' => $sinceDate,
                'sinceTime' => $sinceTime,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
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
    ): PaginatedUsers {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

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
     * @param string $cursor Pagination cursor for thread tweets
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getThread(
        string $id,
        ?string $cursor = null,
        int $pageSize = 20,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getThread($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search tweets by query, Tweet ID, X status URL, or account date window
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
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'q' => $q,
                'advancedQuery' => $advancedQuery,
                'anyWords' => $anyWords,
                'boundingBox' => $boundingBox,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'limit' => $limit,
                'listID' => $listID,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'place' => $place,
                'placeCountry' => $placeCountry,
                'pointRadius' => $pointRadius,
                'queryType' => $queryType,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'sinceDate' => $sinceDate,
                'sinceTime' => $sinceTime,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->search(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
