<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\Tweets\TweetListParams;
use XTwitterScraper\X\Communities\Tweets\TweetListResponse;

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
     * @return BaseResponse<TweetListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|TweetListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
