<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Tweets;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\Like\LikeCreateParams;
use XTwitterScraper\X\Tweets\Like\LikeDeleteParams;
use XTwitterScraper\X\Tweets\Like\LikeDeleteResponse;
use XTwitterScraper\X\Tweets\Like\LikeNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface LikeRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|LikeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LikeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $tweetID,
        array|LikeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|LikeDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LikeDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $tweetID,
        array|LikeDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
