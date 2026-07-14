<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\TweetsRawContract;
use XTwitterScraper\X\Tweets\TweetCreateParams;
use XTwitterScraper\X\Tweets\TweetDeleteParams;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetGetFavoritersParams;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\MediaType;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Quotes;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Replies;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Retweets;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetGetRetweetersParams;
use XTwitterScraper\X\Tweets\TweetGetThreadParams;
use XTwitterScraper\X\Tweets\TweetListParams;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;

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
     *   attachmentURL?: string,
     *   communityID?: string,
     *   isNoteTweet?: bool,
     *   media?: list<string>,
     *   replyToTweetID?: string,
     *   text?: string,
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
     * Get tweet with full text, author, metrics and media
     *
     * @param string $id Numeric tweet ID, 15-20 digits
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s', $id],
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
     * @return BaseResponse<PaginatedTweets>
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
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * Delete tweet
     *
     * @param string $id Tweet ID to delete
     * @param array{account: string}|TweetDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
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
            path: ['x/tweets/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: TweetDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * List users who liked a tweet
     *
     * @param string $id Tweet ID to get favoriters
     * @param array{cursor?: string, pageSize?: int}|TweetGetFavoritersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
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
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * List quote tweets of a tweet
     *
     * @param string $id Numeric tweet ID to get quotes, 15-20 digits
     * @param array{
     *   anyWords?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   hashtags?: string,
     *   includeReplies?: bool,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   mediaType?: MediaType|value-of<MediaType>,
     *   mentioning?: string,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   pageSize?: int,
     *   quotes?: Quotes|value-of<Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: Replies|value-of<Replies>,
     *   retweets?: Retweets|value-of<Retweets>,
     *   retweetsOfTweetID?: string,
     *   sinceDate?: string,
     *   sinceTime?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     * }|TweetGetQuotesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
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
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * List replies to a tweet
     *
     * @param string $id Tweet ID to get replies
     * @param array{
     *   anyWords?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   hashtags?: string,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   mediaType?: TweetGetRepliesParams\MediaType|value-of<TweetGetRepliesParams\MediaType>,
     *   mentioning?: string,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   pageSize?: int,
     *   quotes?: TweetGetRepliesParams\Quotes|value-of<TweetGetRepliesParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: TweetGetRepliesParams\Replies|value-of<TweetGetRepliesParams\Replies>,
     *   retweets?: TweetGetRepliesParams\Retweets|value-of<TweetGetRepliesParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   sinceDate?: string,
     *   sinceTime?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     * }|TweetGetRepliesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
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
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * List users who retweeted a tweet
     *
     * @param string $id Tweet ID to get retweeters
     * @param array{cursor?: string, pageSize?: int}|TweetGetRetweetersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
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
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * Get full conversation thread for a tweet
     *
     * @param string $id Tweet ID to get thread context
     * @param array{cursor?: string, pageSize?: int}|TweetGetThreadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
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
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * Search tweets by query, Tweet ID, X status URL, or account date window
     *
     * @param array{
     *   q: string,
     *   advancedQuery?: string,
     *   anyWords?: string,
     *   boundingBox?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   hashtags?: string,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   limit?: int,
     *   listID?: string,
     *   mediaType?: TweetSearchParams\MediaType|value-of<TweetSearchParams\MediaType>,
     *   mentioning?: string,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   place?: string,
     *   placeCountry?: string,
     *   pointRadius?: string,
     *   queryType?: QueryType|value-of<QueryType>,
     *   quotes?: TweetSearchParams\Quotes|value-of<TweetSearchParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: TweetSearchParams\Replies|value-of<TweetSearchParams\Replies>,
     *   retweets?: TweetSearchParams\Retweets|value-of<TweetSearchParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   sinceDate?: string,
     *   sinceTime?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     * }|TweetSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
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
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'listID' => 'listId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }
}
