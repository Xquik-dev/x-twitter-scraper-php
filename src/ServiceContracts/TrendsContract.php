<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Trends\TrendListResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface TrendsContract
{
    /**
     * @api
     *
     * @param int $count Number of trending topics to return (1-50, default 30)
     * @param int $woeid Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $count = 30,
        int $woeid = 1,
        RequestOptions|array|null $requestOptions = null,
    ): TrendListResponse;
}
