<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\TweetsRawContract;
use XTwitterScraper\X\Tweets\TweetCreateParams;
use XTwitterScraper\X\Tweets\TweetDeleteParams;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetGetFavoritersParams;
use XTwitterScraper\X\Tweets\TweetGetFavoritersResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams;
use XTwitterScraper\X\Tweets\TweetGetQuotesResponse;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetGetRetweetersParams;
use XTwitterScraper\X\Tweets\TweetGetRetweetersResponse;
use XTwitterScraper\X\Tweets\TweetGetThreadParams;
use XTwitterScraper\X\Tweets\TweetGetThreadResponse;
use XTwitterScraper\X\Tweets\TweetListParams;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TweetsRawService implements TweetsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create tweet
     *
     * @param array{
     *   account: string,
     *   text: string,
     *   attachmentURL?: string,
     *   communityID?: string,
     *   isNoteTweet?: bool,
     *   mediaIDs?: list<string>,
     *   replyToTweetID?: string,
     * }|TweetCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|TweetCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/tweets',
            body: (object) $parsed,
            options: $options,
            convert: TweetNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Look up tweet
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $tweetID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s', $tweetID],
            options: $requestOptions,
            convert: TweetGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Get multiple tweets by IDs
     *
     * @param array{ids: string}|TweetListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function list(
        array|TweetListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/tweets',
            query: $parsed,
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Delete tweet
     *
     * @param array{account: string}|TweetDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $tweetID,
        array|TweetDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/tweets/%1$s', $tweetID],
            body: (object) $parsed,
            options: $options,
            convert: TweetDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Get users who liked a tweet
     *
     * @param string $id Tweet ID
     * @param array{cursor?: string}|TweetGetFavoritersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetFavoritersResponse>
     *
     * @throws APIException
     */
    public function getFavoriters(
        string $id,
        array|TweetGetFavoritersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetFavoritersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/favoriters', $id],
            query: $parsed,
            options: $options,
            convert: TweetGetFavoritersResponse::class,
        );
    }

    /**
     * @api
     *
     * Get quote tweets of a tweet
     *
     * @param string $id Tweet ID
     * @param array{
     *   cursor?: string, includeReplies?: bool, sinceTime?: string, untilTime?: string
     * }|TweetGetQuotesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetQuotesResponse>
     *
     * @throws APIException
     */
    public function getQuotes(
        string $id,
        array|TweetGetQuotesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetQuotesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/quotes', $id],
            query: $parsed,
            options: $options,
            convert: TweetGetQuotesResponse::class,
        );
    }

    /**
     * @api
     *
     * Get replies to a tweet
     *
     * @param string $id Tweet ID
     * @param array{
     *   cursor?: string, sinceTime?: string, untilTime?: string
     * }|TweetGetRepliesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetRepliesResponse>
     *
     * @throws APIException
     */
    public function getReplies(
        string $id,
        array|TweetGetRepliesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetRepliesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/replies', $id],
            query: $parsed,
            options: $options,
            convert: TweetGetRepliesResponse::class,
        );
    }

    /**
     * @api
     *
     * Get users who retweeted a tweet
     *
     * @param string $id Tweet ID
     * @param array{cursor?: string}|TweetGetRetweetersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetRetweetersResponse>
     *
     * @throws APIException
     */
    public function getRetweeters(
        string $id,
        array|TweetGetRetweetersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetRetweetersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/retweeters', $id],
            query: $parsed,
            options: $options,
            convert: TweetGetRetweetersResponse::class,
        );
    }

    /**
     * @api
     *
     * Get thread context for a tweet
     *
     * @param string $id Tweet ID
     * @param array{cursor?: string}|TweetGetThreadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetThreadResponse>
     *
     * @throws APIException
     */
    public function getThread(
        string $id,
        array|TweetGetThreadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetThreadParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/thread', $id],
            query: $parsed,
            options: $options,
            convert: TweetGetThreadResponse::class,
        );
    }

    /**
     * @api
     *
     * Search tweets
     *
     * @param array{
     *   q: string,
     *   cursor?: string,
     *   limit?: int,
     *   queryType?: QueryType|value-of<QueryType>,
     *   sinceTime?: string,
     *   untilTime?: string,
     * }|TweetSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetSearchResponse>
     *
     * @throws APIException
     */
    public function search(
        array|TweetSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetSearchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/tweets/search',
            query: $parsed,
            options: $options,
            convert: TweetSearchResponse::class,
        );
    }
}
