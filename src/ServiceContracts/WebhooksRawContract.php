<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Webhooks\Webhook;
use XTwitterScraper\Webhooks\WebhookCreateParams;
use XTwitterScraper\Webhooks\WebhookCreateTelegramLinkParams;
use XTwitterScraper\Webhooks\WebhookCreateTelegramLinkResponse;
use XTwitterScraper\Webhooks\WebhookDeactivateResponse;
use XTwitterScraper\Webhooks\WebhookListDeliveriesParams;
use XTwitterScraper\Webhooks\WebhookListDeliveriesResponse;
use XTwitterScraper\Webhooks\WebhookListParams;
use XTwitterScraper\Webhooks\WebhookListResponse;
use XTwitterScraper\Webhooks\WebhookNewResponse;
use XTwitterScraper\Webhooks\WebhookResumeResponse;
use XTwitterScraper\Webhooks\WebhookTestResponse;
use XTwitterScraper\Webhooks\WebhookUpdateParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface WebhooksRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WebhookCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|WebhookCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param array<string,mixed>|WebhookUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Webhook>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|WebhookUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WebhookListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|WebhookListParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookDeactivateResponse>
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param array<string,mixed>|WebhookListDeliveriesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListDeliveriesResponse>
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        array|WebhookListDeliveriesParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookResumeResponse>
     *
     * @throws APIException
     */
    public function resume(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|WebhookCreateTelegramLinkParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookCreateTelegramLinkResponse>
     *
     * @throws APIException
     */
    public function createTelegramLink(
        array|WebhookCreateTelegramLinkParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
