<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\WebhooksRawContract;
use XTwitterScraper\Webhooks\Webhook;
use XTwitterScraper\Webhooks\WebhookCreateParams;
use XTwitterScraper\Webhooks\WebhookDeactivateResponse;
use XTwitterScraper\Webhooks\WebhookListDeliveriesResponse;
use XTwitterScraper\Webhooks\WebhookListResponse;
use XTwitterScraper\Webhooks\WebhookNewResponse;
use XTwitterScraper\Webhooks\WebhookTestResponse;
use XTwitterScraper\Webhooks\WebhookUpdateParams;

/**
 * Webhook endpoint management & delivery.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class WebhooksRawService implements WebhooksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create webhook
     *
     * @param array{
     *   eventTypes: list<EventType|value-of<EventType>>, url: string
     * }|WebhookCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|WebhookCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WebhookCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'webhooks',
            body: (object) $parsed,
            options: $options,
            convert: WebhookNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Update webhook
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{
     *   eventTypes?: list<EventType|value-of<EventType>>,
     *   isActive?: bool,
     *   url?: string,
     * }|WebhookUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = WebhookUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['webhooks/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: Webhook::class,
        );
    }

    /**
     * @api
     *
     * List webhooks
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'webhooks',
            options: $requestOptions,
            convert: WebhookListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deactivate webhook
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookDeactivateResponse>
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['webhooks/%1$s', $id],
            options: $requestOptions,
            convert: WebhookDeactivateResponse::class,
        );
    }

    /**
     * @api
     *
     * List webhook deliveries
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookListDeliveriesResponse>
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['webhooks/%1$s/deliveries', $id],
            options: $requestOptions,
            convert: WebhookListDeliveriesResponse::class,
        );
    }

    /**
     * @api
     *
     * Test webhook endpoint
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['webhooks/%1$s/test', $id],
            options: $requestOptions,
            convert: WebhookTestResponse::class,
        );
    }
}
