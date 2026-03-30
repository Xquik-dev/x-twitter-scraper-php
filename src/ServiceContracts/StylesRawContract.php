<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Styles\StyleAnalyzeParams;
use XTwitterScraper\Styles\StyleCompareParams;
use XTwitterScraper\Styles\StyleCompareResponse;
use XTwitterScraper\Styles\StyleGetPerformanceResponse;
use XTwitterScraper\Styles\StyleListResponse;
use XTwitterScraper\Styles\StyleProfile;
use XTwitterScraper\Styles\StyleUpdateParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface StylesRawContract
{
    /**
     * @api
     *
     * @param string $username X username of cached style
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleProfile>
     *
     * @throws APIException
     */
    public function retrieve(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $username X username of cached style
     * @param array<string,mixed>|StyleUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleProfile>
     *
     * @throws APIException
     */
    public function update(
        string $username,
        array|StyleUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

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
     * @param string $username X username of cached style
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|StyleAnalyzeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleProfile>
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

    /**
     * @api
     *
     * @param string $username X username of cached style
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<StyleGetPerformanceResponse>
     *
     * @throws APIException
     */
    public function getPerformance(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
