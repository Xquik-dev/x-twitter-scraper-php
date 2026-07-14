<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Radar\RadarGetTrendingTopicsResponse;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Category;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Source;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\RadarContract;

/**
 * AI tweet composition, drafts, writing styles, and radar.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class RadarService implements RadarContract
{
    /**
     * @api
     */
    public RadarRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RadarRawService($client);
    }

    /**
     * @api
     *
     * Get trending topics from curated sources
     *
     * @param string $after cursor for pagination (from prior response nextCursor)
     * @param Category|value-of<Category> $category filter by category
     * @param int $hours lookback window in hours (1-72, default 6)
     * @param int $limit number of items to return (1-100, default 50)
     * @param string $region Region filter. Use `global` or a region code such as `US`, `GB`, `TR`, or `ES`.
     * @param Source|value-of<Source> $source Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTrendingTopics(
        ?string $after = null,
        Category|string|null $category = null,
        int $hours = 6,
        int $limit = 50,
        string $region = 'global',
        Source|string|null $source = null,
        RequestOptions|array|null $requestOptions = null,
    ): RadarGetTrendingTopicsResponse {
        $params = Util::removeNulls(
            [
                'after' => $after,
                'category' => $category,
                'hours' => $hours,
                'limit' => $limit,
                'region' => $region,
                'source' => $source,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTrendingTopics(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
