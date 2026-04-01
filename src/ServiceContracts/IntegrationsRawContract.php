<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Integrations\IntegrationCreateParams;
use XTwitterScraper\Integrations\IntegrationDeleteResponse;
use XTwitterScraper\Integrations\IntegrationGetResponse;
use XTwitterScraper\Integrations\IntegrationListDeliveriesParams;
use XTwitterScraper\Integrations\IntegrationListDeliveriesResponse;
use XTwitterScraper\Integrations\IntegrationListResponse;
use XTwitterScraper\Integrations\IntegrationNewResponse;
use XTwitterScraper\Integrations\IntegrationSendTestResponse;
use XTwitterScraper\Integrations\IntegrationUpdateParams;
use XTwitterScraper\Integrations\IntegrationUpdateResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface IntegrationsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|IntegrationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|IntegrationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationGetResponse>
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
     * @param array<string,mixed>|IntegrationUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|IntegrationUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationListResponse>
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
     * @return BaseResponse<IntegrationDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array<string,mixed>|IntegrationListDeliveriesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationListDeliveriesResponse>
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        array|IntegrationListDeliveriesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationSendTestResponse>
     *
     * @throws APIException
     */
    public function sendTest(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
