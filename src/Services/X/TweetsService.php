<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\TweetsContract;
use XTwitterScraper\Services\X\Tweets\LikeService;
use XTwitterScraper\Services\X\Tweets\RetweetService;
use XTwitterScraper\X\Tweets\TweetGetFavoritersResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesResponse;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetRetweetersResponse;
use XTwitterScraper\X\Tweets\TweetGetThreadResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse;

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
    ): TweetNewResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'text' => $text,
                'attachmentURL' => $attachmentURL,
                'communityID' => $communityID,
                'isNoteTweet' => $isNoteTweet,
                'mediaIDs' => $mediaIDs,
                'replyToTweetID' => $replyToTweetID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

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
    ): mixed {
        $params = Util::removeNulls(['ids' => $ids]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get users who liked a tweet
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
    ): TweetGetFavoritersResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getFavoriters($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get quote tweets of a tweet
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
    ): TweetGetQuotesResponse {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'includeReplies' => $includeReplies,
                'sinceTime' => $sinceTime,
                'untilTime' => $untilTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getQuotes($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get replies to a tweet
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
    ): TweetGetRepliesResponse {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'sinceTime' => $sinceTime,
                'untilTime' => $untilTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getReplies($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get users who retweeted a tweet
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
    ): TweetGetRetweetersResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getRetweeters($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get thread context for a tweet
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
    ): TweetGetThreadResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getThread($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search tweets
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
    ): TweetSearchResponse {
        $params = Util::removeNulls(
            [
                'q' => $q,
                'cursor' => $cursor,
                'limit' => $limit,
                'queryType' => $queryType,
                'sinceTime' => $sinceTime,
                'untilTime' => $untilTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->search(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
