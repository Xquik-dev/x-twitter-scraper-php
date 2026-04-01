<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetGetFavoritersResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesResponse;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetGetRetweetersResponse;
use XTwitterScraper\X\Tweets\TweetGetThreadResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse;

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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $tweetID,
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
    ): mixed;

    /**
     * @api
     *
     * @param string $account X account (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $tweetID,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): TweetDeleteResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID
     * @param string $cursor Pagination cursor from previous response
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getFavoriters(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetGetFavoritersResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID
     * @param string $cursor Pagination cursor
     * @param bool $includeReplies Include replies (default false)
     * @param string $sinceTime Unix timestamp - filter after
     * @param string $untilTime Unix timestamp - filter before
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
    ): TweetGetQuotesResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID
     * @param string $cursor Pagination cursor
     * @param string $sinceTime Unix timestamp - filter after
     * @param string $untilTime Unix timestamp - filter before
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
    ): TweetGetRepliesResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID
     * @param string $cursor Pagination cursor
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getRetweeters(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetGetRetweetersResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID
     * @param string $cursor Pagination cursor
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getThread(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetGetThreadResponse;

    /**
     * @api
     *
     * @param string $q Search query (keywords,
     * @param string $cursor Pagination cursor from previous response
     * @param int $limit Deprecated — use cursor-based pagination instead
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
    ): TweetSearchResponse;
}
