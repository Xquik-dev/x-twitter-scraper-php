<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

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
 * Webhook endpoint management and delivery.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
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
     * @param string $id resource ID returned by the matching create or list endpoint
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
    ): BaseResponse {
        [$parsed, $options] = WebhookListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'webhooks',
            query: $parsed,
            options: $options,
            convert: WebhookListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deactivate webhook
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
    ): BaseResponse {
        [$parsed, $options] = WebhookListDeliveriesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['webhooks/%1$s/deliveries', $id],
            query: $parsed,
            options: $options,
            convert: WebhookListDeliveriesResponse::class,
        );
    }

    /**
     * @api
     *
     * Test and resume webhook endpoint
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['webhooks/%1$s/resume', $id],
            options: $requestOptions,
            convert: WebhookResumeResponse::class,
        );
    }

    /**
     * @api
     *
     * Test webhook endpoint
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['webhooks/%1$s/test', $id],
            options: $requestOptions,
            convert: WebhookTestResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns a t.me link to @XquikBot that connects a Telegram chat to the account's monitor events. Opening it & pressing Start connects the chat, which then gets each alert as a message. Alerts that wait together come as 1 digest. A busy chat gets 5 quick messages, then 1 every 30 s. Only 1 message a minute rings. The link works once, within 15 minutes. The chat appears in the webhook list with the URL `telegram:<chat ID>`, with deliveries, retries & resume as any webhook. In the chat, /stop pauses its alerts. It costs no credits.
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
    ): BaseResponse {
        [$parsed, $options] = WebhookCreateTelegramLinkParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'webhooks/telegram',
            body: (object) $parsed,
            options: $options,
            convert: WebhookCreateTelegramLinkResponse::class,
        );
    }
}
