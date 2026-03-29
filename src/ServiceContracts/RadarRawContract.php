<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Radar\RadarGetTrendingTopicsResponse;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface RadarRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|RadarRetrieveTrendingTopicsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RadarGetTrendingTopicsResponse>
     *
     * @throws APIException
     */
    public function retrieveTrendingTopics(
        array|RadarRetrieveTrendingTopicsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
