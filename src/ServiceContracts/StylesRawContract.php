<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Styles\StyleAnalyzeParams;
use XTwitterScraper\Styles\StyleAnalyzeResponse;
use XTwitterScraper\Styles\StyleCompareParams;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleListResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface StylesRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|StyleAnalyzeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleAnalyzeResponse>
     *
     * @throws APIException
     */
    public function analyze(
        array|StyleAnalyzeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|StyleCompareParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleCompareResponse>
     *
     * @throws APIException
     */
    public function compare(
        array|StyleCompareParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
