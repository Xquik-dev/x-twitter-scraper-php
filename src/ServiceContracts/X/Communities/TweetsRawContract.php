<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\CursorPage;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams;
use XTwitterScraper\X\Communities\Tweets\TweetListParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface TweetsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TweetListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CursorPage<PaginatedTweets>>
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
     * @param string $id Community ID for tweet lookup
     * @param array<string,mixed>|TweetListByCommunityParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CursorPage<PaginatedTweets>>
     *
     * @throws APIException
     */
    public function listByCommunity(
        string $id,
        array|TweetListByCommunityParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
