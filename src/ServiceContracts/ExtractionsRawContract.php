<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams;
use XTwitterScraper\Extractions\ExtractionEstimateCostResponse;
use XTwitterScraper\Extractions\ExtractionExportResultsParams;
use XTwitterScraper\Extractions\ExtractionGetResponse;
use XTwitterScraper\Extractions\ExtractionListParams;
use XTwitterScraper\Extractions\ExtractionListResponse;
use XTwitterScraper\Extractions\ExtractionRetrieveParams;
use XTwitterScraper\Extractions\ExtractionRunParams;
use XTwitterScraper\Extractions\ExtractionRunResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ExtractionsRawContract
{
    /**
     * @api
     *
     * @param string $id Extraction public ID (UUID)
     * @param array<string,mixed>|ExtractionRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ExtractionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ExtractionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ExtractionEstimateCostParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionEstimateCostResponse>
     *
     * @throws APIException
     */
    public function estimateCost(
        array|ExtractionEstimateCostParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Extraction public ID
     * @param array<string,mixed>|ExtractionExportResultsParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ExtractionRunParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionRunResponse>
     *
     * @throws APIException
     */
    public function run(
        array|ExtractionRunParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
