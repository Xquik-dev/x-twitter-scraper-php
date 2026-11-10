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
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\TweetsRawContract;
use XTwitterScraper\X\Tweets\TweetBookmarkParams;
use XTwitterScraper\X\Tweets\TweetCheckRepostParams;
use XTwitterScraper\X\Tweets\TweetCheckRepostResponse;
use XTwitterScraper\X\Tweets\TweetCreateParams;
use XTwitterScraper\X\Tweets\TweetDeleteParams;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetEmbedParams;
use XTwitterScraper\X\Tweets\TweetEmbedResponse;
use XTwitterScraper\X\Tweets\TweetGetFavoritersParams;
use XTwitterScraper\X\Tweets\TweetGetHiddenRepliesParams;
use XTwitterScraper\X\Tweets\TweetGetInsightsParams;
use XTwitterScraper\X\Tweets\TweetGetInsightsResponse;
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
use XTwitterScraper\X\Tweets\TweetGetRetweeterIdsParams;
use XTwitterScraper\X\Tweets\TweetGetRetweetersParams;
use XTwitterScraper\X\Tweets\TweetGetSubtitlesParams;
use XTwitterScraper\X\Tweets\TweetGetSubtitlesResponse;
use XTwitterScraper\X\Tweets\TweetGetThreadParams;
use XTwitterScraper\X\Tweets\TweetListParams;
use XTwitterScraper\X\Tweets\TweetListTopParams;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetResolveLinksParams;
use XTwitterScraper\X\Tweets\TweetResolveLinksResponse;
use XTwitterScraper\X\Tweets\TweetRetrieveParams;
use XTwitterScraper\X\Tweets\TweetSearchParams;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse;
use XTwitterScraper\X\Tweets\TweetTranslateParams;
use XTwitterScraper\X\Tweets\TweetTranslateResponse;
use XTwitterScraper\X\Tweets\TweetUnbookmarkParams;
use XTwitterScraper\XWriteAction;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
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
     *   mediaIDs?: list<string>,
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
     * @param array<string,mixed>|TweetRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|TweetRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = TweetRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s', $id],
            query: $parsed,
            options: $options,
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
     * @param array{
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   hashtags?: string,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   maxFaves?: int,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: TweetGetThreadParams\MediaType|value-of<TweetGetThreadParams\MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   pageSize?: int,
     *   quotes?: TweetGetThreadParams\Quotes|value-of<TweetGetThreadParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: TweetGetThreadParams\Replies|value-of<TweetGetThreadParams\Replies>,
     *   retweets?: TweetGetThreadParams\Retweets|value-of<TweetGetThreadParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   sinceDate?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     * }|TweetGetThreadParams $params
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
     * No-mode search maximizes coverage. New cursorless `Latest` sessions return rows newest-first across cursor pages. Existing cursors preserve their established ordering.
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
     *   imageShows?: string,
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
     *   topic?: string,
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

    /**
     * @api
     *
     * Returns the tweets X ranks highest by 1 metric over the last day, week or month. Covers all of X unless you pick a country or a language. Pages hold up to 20 tweets, and the list ends at 100. Each tweet costs 1 credit.
     *
     * Top tweet lists come back reliably.
     *
     * @param array<string,mixed>|TweetListTopParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets2>
     *
     * @throws APIException
     */
    public function listTop(
        array|TweetListTopParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetListTopParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/tweets/top',
            query: $parsed,
            options: $options,
            convert: PaginatedTweets2::class,
        );
    }

    /**
     * @api
     *
     * Bookmarks a post through a connected X account. Only that account sees its bookmarks, and GET /x/bookmarks lists them.
     *
     * @param array<string,mixed>|TweetBookmarkParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XWriteAction>
     *
     * @throws APIException
     */
    public function bookmark(
        string $id,
        array|TweetBookmarkParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetBookmarkParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/tweets/%1$s/bookmark', $id],
            body: (object) $parsed,
            options: $options,
            convert: XWriteAction::class,
        );
    }

    /**
     * @api
     *
     * Removes a bookmark through a connected X account.
     *
     * @param array<string,mixed>|TweetUnbookmarkParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XWriteAction>
     *
     * @throws APIException
     */
    public function unbookmark(
        string $id,
        array|TweetUnbookmarkParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetUnbookmarkParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/tweets/%1$s/bookmark', $id],
            body: (object) $parsed,
            options: $options,
            convert: XWriteAction::class,
        );
    }

    /**
     * @api
     *
     * Returns whether 1 account reposted the post. It finds recent reposts. An older repost can return false, with complete false. Each check costs 1 credit.
     *
     * @param array<string,mixed>|TweetCheckRepostParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetCheckRepostResponse>
     *
     * @throws APIException
     */
    public function checkRepost(
        string $id,
        array|TweetCheckRepostParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetCheckRepostParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/retweeters/check', $id],
            query: $parsed,
            options: $options,
            convert: TweetCheckRepostResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the user IDs of a post's reposters, in the order & pages of /x/tweets/{id}/retweeters. Use it when you need IDs only. Each ID costs 1 credit. A post nobody reposted returns an empty list for free.
     *
     * @param array<string,mixed>|TweetGetRetweeterIdsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUserIDs>
     *
     * @throws APIException
     */
    public function getRetweeterIds(
        string $id,
        array|TweetGetRetweeterIdsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetRetweeterIdsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/retweeter-ids', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUserIDs::class,
        );
    }

    /**
     * @api
     *
     * Returns the replies the post's author hid, oldest first, with the replies to them. A post without hidden replies returns an empty list.
     *
     * @param array<string,mixed>|TweetGetHiddenRepliesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets2>
     *
     * @throws APIException
     */
    public function getHiddenReplies(
        string $id,
        array|TweetGetHiddenRepliesParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetHiddenRepliesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/hidden-replies', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedTweets2::class,
        );
    }

    /**
     * @api
     *
     * Returns X's own translation of 1 public tweet into the language you pick, with the links, mentions, and tags X places in the translated text.
     *
     * Posts & bios can be translated into your language.
     *
     * @param array<string,mixed>|TweetTranslateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetTranslateResponse>
     *
     * @throws APIException
     */
    public function translate(
        string $id,
        array|TweetTranslateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetTranslateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/translation', $id],
            query: $parsed,
            options: $options,
            convert: TweetTranslateResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns engagement insights for 1 tweet. They are engagements per hour since it went up, per view and per follower of its author, and how far it spread. Each report costs 1 credit, whatever it reads.
     *
     * @param array<string,mixed>|TweetGetInsightsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetInsightsResponse>
     *
     * @throws APIException
     */
    public function getInsights(
        string $id,
        array|TweetGetInsightsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetInsightsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/insights', $id],
            query: $parsed,
            options: $options,
            convert: TweetGetInsightsResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the HTML that X gives websites to embed 1 public tweet, with the tweet's link and author.
     *
     * @param array<string,mixed>|TweetEmbedParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetEmbedResponse>
     *
     * @throws APIException
     */
    public function embed(
        string $id,
        array|TweetEmbedParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetEmbedParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/embed', $id],
            query: $parsed,
            options: $options,
            convert: TweetEmbedResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the caption tracks of 1 public tweet's videos. Each track has its language, name, timed cues, and full text. A tweet without video, or a video without captions, returns no track and costs nothing.
     *
     * Video subtitles come with timed cues.
     *
     * @param array<string,mixed>|TweetGetSubtitlesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetGetSubtitlesResponse>
     *
     * @throws APIException
     */
    public function getSubtitles(
        string $id,
        array|TweetGetSubtitlesParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetGetSubtitlesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/tweets/%1$s/subtitles', $id],
            query: $parsed,
            options: $options,
            convert: TweetGetSubtitlesResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns where each t.co link leads, as X's own redirect says. Xquik reads the redirect and never visits the target site. A link t.co does not have comes back without `resolvedUrl` and costs nothing. A link X does not answer for in time comes back in `unprocessedUrls`, free. Each resolved link costs 1 credit.
     *
     * @param array<string,mixed>|TweetResolveLinksParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetResolveLinksResponse>
     *
     * @throws APIException
     */
    public function resolveLinks(
        array|TweetResolveLinksParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetResolveLinksParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/links/resolve',
            query: $parsed,
            options: $options,
            convert: TweetResolveLinksResponse::class,
        );
    }
}
