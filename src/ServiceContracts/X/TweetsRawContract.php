<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\TweetCreateParams;
use XTwitterScraper\X\Tweets\TweetGetFavoritersParams;
use XTwitterScraper\X\Tweets\TweetGetFavoritersResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams;
use XTwitterScraper\X\Tweets\TweetGetQuotesResponse;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetRetweetersParams;
use XTwitterScraper\X\Tweets\TweetGetRetweetersResponse;
use XTwitterScraper\X\Tweets\TweetGetThreadParams;
use XTwitterScraper\X\Tweets\TweetGetThreadResponse;
use XTwitterScraper\X\Tweets\TweetListParams;
use XTwitterScraper\X\Tweets\TweetListResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams;
use XTwitterScraper\X\Tweets\TweetSearchResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param array<string,mixed>|TweetListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TweetListResponse>
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
     * @param string $id Tweet ID to get favoriters
     * @param array<string,mixed>|TweetGetFavoritersParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to get quotes
     * @param array<string,mixed>|TweetGetQuotesParams $params
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
     * @return BaseResponse<TweetGetRetweetersResponse>
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
     * @return BaseResponse<TweetGetThreadResponse>
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
     * @return BaseResponse<TweetSearchResponse>
     *
     * @throws APIException
     */
    public function search(
        array|TweetSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
