<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Radar\RadarGetTrendingTopicsResponse;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Source;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\RadarContract;

/**
 * Tweet composition, drafts, writing styles & radar.
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
     * @param string $category Filter by category (general, tech, dev, etc.)
     * @param int $count Number of items to return
     * @param int $hours Lookback window in hours
     * @param string $region Region filter (us, global, etc.)
     * @param Source|value-of<Source> $source Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTrendingTopics(
        ?string $category = null,
        ?int $count = null,
        ?int $hours = null,
        ?string $region = null,
        Source|string|null $source = null,
        RequestOptions|array|null $requestOptions = null,
    ): RadarGetTrendingTopicsResponse {
        $params = Util::removeNulls(
            [
                'category' => $category,
                'count' => $count,
                'hours' => $hours,
                'region' => $region,
                'source' => $source,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTrendingTopics(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
