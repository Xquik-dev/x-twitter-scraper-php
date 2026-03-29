<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Trends\TrendListParams;
use XTwitterScraper\Trends\TrendListResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface TrendsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TrendListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TrendListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|TrendListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
