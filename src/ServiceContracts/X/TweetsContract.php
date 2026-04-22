<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
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
     * @param string $account X account (@username or account ID)
     * @param list<string> $mediaIDs
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $account,
        string $text,
        ?string $attachmentURL = null,
        ?string $communityID = null,
        ?bool $isNoteTweet = null,
        ?array $mediaIDs = null,
        ?string $replyToTweetID = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetNewResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID
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
     * @param string $id Tweet ID to delete
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): TweetDeleteResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to get favoriters
     * @param string $cursor Pagination cursor for favoriters
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getFavoriters(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers;

    /**
     * @api
     *
     * @param string $id Tweet ID to get quotes
     * @param string $cursor Pagination cursor for quote tweets
     * @param bool $includeReplies Include reply quotes (default false)
     * @param string $sinceTime Unix timestamp - return quotes posted after this time
     * @param string $untilTime Unix timestamp - return quotes posted before this time
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getQuotes(
        string $id,
        ?string $cursor = null,
        ?bool $includeReplies = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $id Tweet ID to get replies
     * @param string $cursor Pagination cursor for tweet replies
     * @param string $sinceTime Unix timestamp - return replies posted after this time
     * @param string $untilTime Unix timestamp - return replies posted before this time
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getReplies(
        string $id,
        ?string $cursor = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $id Tweet ID to get retweeters
     * @param string $cursor Pagination cursor for retweeters
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getRetweeters(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers;

    /**
     * @api
     *
     * @param string $id Tweet ID to get thread context
     * @param string $cursor Pagination cursor for thread tweets
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getThread(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $q Search query (keywords,
     * @param string $cursor Pagination cursor from previous response
     * @param int $limit Max tweets to return (server paginates internally). Omit for single page (~20).
     * @param QueryType|value-of<QueryType> $queryType Sort order — Latest (chronological) or Top (engagement-ranked)
     * @param string $sinceTime ISO 8601 timestamp — only return tweets after this time
     * @param string $untilTime ISO 8601 timestamp — only return tweets before this time
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function search(
        string $q,
        ?string $cursor = null,
        int $limit = 20,
        QueryType|string $queryType = 'Latest',
        ?string $sinceTime = null,
        ?string $untilTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;
}
