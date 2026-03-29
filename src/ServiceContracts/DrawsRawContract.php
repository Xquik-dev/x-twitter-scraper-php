<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Draws\DrawExportParams;
use XTwitterScraper\Draws\DrawGetResponse;
use XTwitterScraper\Draws\DrawListParams;
use XTwitterScraper\Draws\DrawListResponse;
use XTwitterScraper\Draws\DrawRunParams;
use XTwitterScraper\Draws\DrawRunResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface DrawsRawContract
{
    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DrawGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DrawListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DrawListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|DrawListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array<string,mixed>|DrawExportParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function export(
        string $id,
        array|DrawExportParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DrawRunParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DrawRunResponse>
     *
     * @throws APIException
     */
    public function run(
        array|DrawRunParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
