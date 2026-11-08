<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
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
use XTwitterScraper\X\Tweets\TweetGetRepliesParams;
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
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse;
use XTwitterScraper\X\Tweets\TweetTranslateParams;
use XTwitterScraper\X\Tweets\TweetTranslateResponse;
use XTwitterScraper\X\Tweets\TweetUnbookmarkParams;
use XTwitterScraper\XWriteAction;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface TweetsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TweetCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|TweetCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TweetListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function list(
        array|TweetListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: Tweet ID to delete
     * @param array<string,mixed>|TweetDeleteParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to get favoriters
     * @param array<string,mixed>|TweetGetFavoritersParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Numeric tweet ID to get quotes, 15-20 digits
     * @param array<string,mixed>|TweetGetQuotesParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to get replies
     * @param array<string,mixed>|TweetGetRepliesParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to get retweeters
     * @param array<string,mixed>|TweetGetRetweetersParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to get thread context
     * @param array<string,mixed>|TweetGetThreadParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TweetSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets|TweetSearchCoverageResponse>
     *
     * @throws APIException
     */
    public function search(
        array|TweetSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
