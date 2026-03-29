<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Tweets;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\Retweet\RetweetCreateParams;
use XTwitterScraper\X\Tweets\Retweet\RetweetDeleteParams;
use XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse;
use XTwitterScraper\X\Tweets\Retweet\RetweetNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface RetweetRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|RetweetCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RetweetNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $tweetID,
        array|RetweetCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|RetweetDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RetweetDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $tweetID,
        array|RetweetDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
