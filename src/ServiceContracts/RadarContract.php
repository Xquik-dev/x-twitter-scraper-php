<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Radar\RadarGetTrendingTopicsResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface RadarContract
{
    /**
     * @api
     *
     * @param string $category Filter by category (general, tech, dev, etc.)
     * @param int $count Number of items to return
     * @param int $hours Lookback window in hours
     * @param string $region Region filter (us, global, etc.)
     * @param string $source Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTrendingTopics(
        ?string $category = null,
        ?int $count = null,
        ?int $hours = null,
        ?string $region = null,
        ?string $source = null,
        RequestOptions|array|null $requestOptions = null,
    ): RadarGetTrendingTopicsResponse;
}
