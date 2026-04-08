<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\TrendsContract;
use XTwitterScraper\Trends\TrendListResponse;

/**
 * Trending topics by region.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TrendsService implements TrendsContract
{
    /**
     * @api
     */
    public TrendsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TrendsRawService($client);
    }

    /**
     * @api
     *
     * Get regional trending topics
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
    ): TrendListResponse {
        $params = Util::removeNulls(['count' => $count, 'woeid' => $woeid]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
