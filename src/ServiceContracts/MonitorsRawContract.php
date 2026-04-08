<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Monitors\Monitor;
use XTwitterScraper\Monitors\MonitorCreateParams;
use XTwitterScraper\Monitors\MonitorDeactivateResponse;
use XTwitterScraper\Monitors\MonitorListResponse;
use XTwitterScraper\Monitors\MonitorNewResponse;
use XTwitterScraper\Monitors\MonitorUpdateParams;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface MonitorsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|MonitorCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|MonitorCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Monitor>
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
     * @param string $id Resource ID (stringified bigint)
     * @param array<string,mixed>|MonitorUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Monitor>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|MonitorUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorDeactivateResponse>
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
