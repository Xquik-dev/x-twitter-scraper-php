<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams;
use XTwitterScraper\Extractions\ExtractionEstimateCostResponse;
use XTwitterScraper\Extractions\ExtractionExportResultsParams;
use XTwitterScraper\Extractions\ExtractionExportResultsParams\Format;
use XTwitterScraper\Extractions\ExtractionGetResponse;
use XTwitterScraper\Extractions\ExtractionListParams;
use XTwitterScraper\Extractions\ExtractionListParams\Status;
use XTwitterScraper\Extractions\ExtractionListParams\ToolType;
use XTwitterScraper\Extractions\ExtractionListResponse;
use XTwitterScraper\Extractions\ExtractionRetrieveParams;
use XTwitterScraper\Extractions\ExtractionRunParams;
use XTwitterScraper\Extractions\ExtractionRunResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ExtractionsRawContract;

/**
 * Bulk data extraction (20 tool types).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ExtractionsRawService implements ExtractionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get extraction results
     *
     * @param string $id Extraction public ID (UUID)
     * @param array{after?: string, limit?: int}|ExtractionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|ExtractionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['extractions/%1$s', $id],
            query: $parsed,
            options: $options,
            convert: ExtractionGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List extraction jobs
     *
     * @param array{
     *   after?: string,
     *   limit?: int,
     *   status?: Status|value-of<Status>,
     *   toolType?: value-of<ToolType>,
     * }|ExtractionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ExtractionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'extractions',
            query: $parsed,
            options: $options,
            convert: ExtractionListResponse::class,
        );
    }

    /**
     * @api
     *
     * Estimate extraction cost
     *
     * @param array{
     *   toolType: value-of<ExtractionEstimateCostParams\ToolType>,
     *   advancedQuery?: string,
     *   exactPhrase?: string,
     *   excludeWords?: string,
     *   searchQuery?: string,
     *   targetCommunityID?: string,
     *   targetListID?: string,
     *   targetSpaceID?: string,
     *   targetTweetID?: string,
     *   targetUsername?: string,
     * }|ExtractionEstimateCostParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionEstimateCostResponse>
     *
     * @throws APIException
     */
    public function estimateCost(
        array|ExtractionEstimateCostParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionEstimateCostParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'extractions/estimate',
            body: (object) $parsed,
            options: $options,
            convert: ExtractionEstimateCostResponse::class,
        );
    }

    /**
     * @api
     *
     * Export extraction results
     *
     * @param string $id Extraction public ID
     * @param array{
     *   format?: Format|value-of<Format>
     * }|ExtractionExportResultsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function exportResults(
        string $id,
        array|ExtractionExportResultsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionExportResultsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['extractions/%1$s/export', $id],
            query: $parsed,
            headers: ['Accept' => 'application/octet-stream'],
            options: $options,
            convert: 'string',
        );
    }

    /**
     * @api
     *
     * Run extraction
     *
     * @param array{
     *   toolType: value-of<ExtractionRunParams\ToolType>,
     *   advancedQuery?: string,
     *   exactPhrase?: string,
     *   excludeWords?: string,
     *   searchQuery?: string,
     *   targetCommunityID?: string,
     *   targetListID?: string,
     *   targetSpaceID?: string,
     *   targetTweetID?: string,
     *   targetUsername?: string,
     * }|ExtractionRunParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionRunResponse>
     *
     * @throws APIException
     */
    public function run(
        array|ExtractionRunParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionRunParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'extractions',
            body: (object) $parsed,
            options: $options,
            convert: ExtractionRunResponse::class,
        );
    }
}
