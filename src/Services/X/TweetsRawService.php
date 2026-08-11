<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

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
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Mode;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Scope;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Sort;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetGetRetweetersParams;
use XTwitterScraper\X\Tweets\TweetGetThreadParams;
use XTwitterScraper\X\Tweets\TweetListParams;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse;

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
     *   idempotencyKey: string,
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/tweets',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
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
     * @param string $id Path param: Tweet ID to delete
     * @param array{account: string, idempotencyKey: string}|TweetDeleteParams $params
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/tweets/%1$s', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: TweetDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns liker profiles that X makes visible for the post. X can withhold liker identities even when the post reports likes. In that case this endpoint returns 424 `favoriters_unavailable` instead of a misleading empty success.
     *
     * @param string $id Tweet ID to get favoriters
     * @param array{
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   pageSize?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|TweetGetFavoritersParams $params
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
     *   blueVerifiedOnly?: bool,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   includeReplies?: bool,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: MediaType|value-of<MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   pageSize?: int,
     *   quotes?: Quotes|value-of<Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: Replies|value-of<Replies>,
     *   retweets?: Retweets|value-of<Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   sinceTime?: string,
     *   source?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
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
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * Returns direct replies. Omit mode for automatic maximum coverage with resumable pagination. Complete mode returns nested replies, diagnostics, and 424 when direct coverage stays below 80%.
     *
     * @param string $id Tweet ID to get replies
     * @param array{
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeOriginalAuthor?: bool,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   hasMediaOnly?: bool,
     *   includeOriginalPost?: bool,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   limit?: int,
     *   maxDepth?: int,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: TweetGetRepliesParams\MediaType|value-of<TweetGetRepliesParams\MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   mode?: Mode|value-of<Mode>,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   pageSize?: int,
     *   quotes?: TweetGetRepliesParams\Quotes|value-of<TweetGetRepliesParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: TweetGetRepliesParams\Replies|value-of<TweetGetRepliesParams\Replies>,
     *   retweets?: TweetGetRepliesParams\Retweets|value-of<TweetGetRepliesParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   scope?: Scope|value-of<Scope>,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   sinceTime?: string,
     *   sort?: Sort|value-of<Sort>,
     *   source?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
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
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: TweetGetRepliesResponse::class,
        );
    }

    /**
     * @api
     *
     * List users who retweeted a tweet
     *
     * @param string $id Tweet ID to get retweeters
     * @param array{
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   pageSize?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|TweetGetRetweetersParams $params
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
     * No-mode search maximizes coverage.
     *
     * @param array{
     *   q: string,
     *   advancedQuery?: string,
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   boundingBox?: string,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   limit?: int,
     *   listID?: string,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: TweetSearchParams\MediaType|value-of<TweetSearchParams\MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   mode?: TweetSearchParams\Mode|value-of<TweetSearchParams\Mode>,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   place?: string,
     *   placeCountry?: string,
     *   pointRadius?: string,
     *   queryType?: QueryType|value-of<QueryType>,
     *   quotes?: TweetSearchParams\Quotes|value-of<TweetSearchParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: TweetSearchParams\Replies|value-of<TweetSearchParams\Replies>,
     *   retweets?: TweetSearchParams\Retweets|value-of<TweetSearchParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   sinceTime?: string,
     *   source?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
     * }|TweetSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets|TweetSearchCoverageResponse>
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
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: TweetSearchResponse::class,
        );
    }
}
