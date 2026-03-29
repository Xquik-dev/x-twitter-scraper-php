<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\TrendsRawContract;
use XTwitterScraper\Trends\TrendListParams;
use XTwitterScraper\Trends\TrendListResponse;

/**
 * Trending topics by region.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TrendsRawService implements TrendsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get trending topics
     *
     * @param array{count?: int, woeid?: int}|TrendListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TrendListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|TrendListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TrendListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'trends',
            query: $parsed,
            options: $options,
            convert: TrendListResponse::class,
        );
    }
}
