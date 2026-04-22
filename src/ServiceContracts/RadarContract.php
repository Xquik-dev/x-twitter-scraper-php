<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Radar\RadarGetTrendingTopicsResponse;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Category;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Source;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface RadarContract
{
    /**
     * @api
     *
     * @param string $after cursor for pagination (from prior response nextCursor)
     * @param Category|value-of<Category> $category filter by category
     * @param int $hours lookback window in hours (1-168, default 24)
     * @param int $limit number of items to return (1-100, default 50)
     * @param string $region Region filter (us, global, etc.)
     * @param Source|value-of<Source> $source Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTrendingTopics(
        ?string $after = null,
        Category|string|null $category = null,
        int $hours = 24,
        int $limit = 50,
        ?string $region = null,
        Source|string|null $source = null,
        RequestOptions|array|null $requestOptions = null,
    ): RadarGetTrendingTopicsResponse;
}
