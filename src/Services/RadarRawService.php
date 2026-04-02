<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Radar\RadarGetTrendingTopicsResponse;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Source;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\RadarRawContract;

/**
 * Tweet composition, drafts, writing styles & radar.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class RadarRawService implements RadarRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get trending topics from curated sources
     *
     * @param array{
     *   category?: string,
     *   count?: int,
     *   hours?: int,
     *   region?: string,
     *   source?: value-of<Source>,
     * }|RadarRetrieveTrendingTopicsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RadarGetTrendingTopicsResponse>
     *
     * @throws APIException
     */
    public function retrieveTrendingTopics(
        array|RadarRetrieveTrendingTopicsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RadarRetrieveTrendingTopicsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'radar',
            query: $parsed,
            options: $options,
            convert: RadarGetTrendingTopicsResponse::class,
        );
    }
}
