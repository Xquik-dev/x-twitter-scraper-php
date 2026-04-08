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
     * @param string $id Tweet ID to retweet
     * @param array<string,mixed>|RetweetCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RetweetNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|RetweetCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to unretweet
     * @param array<string,mixed>|RetweetDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RetweetDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|RetweetDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
