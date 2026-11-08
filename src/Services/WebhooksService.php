<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\WebhooksContract;
use XTwitterScraper\Webhooks\Webhook;
use XTwitterScraper\Webhooks\WebhookCreateTelegramLinkResponse;
use XTwitterScraper\Webhooks\WebhookDeactivateResponse;
use XTwitterScraper\Webhooks\WebhookListDeliveriesResponse;
use XTwitterScraper\Webhooks\WebhookListResponse;
use XTwitterScraper\Webhooks\WebhookNewResponse;
use XTwitterScraper\Webhooks\WebhookResumeResponse;
use XTwitterScraper\Webhooks\WebhookTestResponse;

/**
 * Webhook endpoint management and delivery.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class WebhooksService implements WebhooksContract
{
    /**
     * @api
     */
    public WebhooksRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WebhooksRawService($client);
    }

    /**
     * @api
     *
     * Create webhook
     *
     * @param list<EventType|value-of<EventType>> $eventTypes array of event types to subscribe to
     * @param string $url HTTPS URL
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $eventTypes,
        string $url,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookNewResponse {
        $params = Util::removeNulls(['eventTypes' => $eventTypes, 'url' => $url]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update webhook
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param list<EventType|value-of<EventType>> $eventTypes array of event types to subscribe to
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?array $eventTypes = null,
        ?bool $isActive = null,
        ?string $url = null,
        RequestOptions|array|null $requestOptions = null,
    ): Webhook {
        $params = Util::removeNulls(
            ['eventTypes' => $eventTypes, 'isActive' => $isActive, 'url' => $url]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List webhooks
     *
     * @param int|null $limit Maximum items per page, from 1 to 10,000. Default 200. Pass nextCursor as cursor for the next page.
     * @param string|null $cursor Previous nextCursor. The after alias also works. Offset pagination is not supported.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null
    ): WebhookListResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'cursor' => $cursor,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deactivate webhook
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): WebhookDeactivateResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deactivate($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List webhook deliveries
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param int|null $limit Maximum deliveries per page, from 1 to 10,000. Default 100. Pass nextCursor as cursor for the next page.
     * @param string|null $cursor Previous nextCursor. The after alias also works. Offset pagination is not supported.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        ?int $limit = null,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null
    ): WebhookListDeliveriesResponse {
        $params = Util::removeNulls(
            [
                'limit' => $limit,
                'cursor' => $cursor,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listDeliveries($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Test and resume webhook endpoint
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function resume(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): WebhookResumeResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->resume($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Test webhook endpoint
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): WebhookTestResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->test($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns a t.me link to @XquikBot that connects a Telegram chat to the account's monitor events. Opening it & pressing Start connects the chat, which then gets each alert as a message. Alerts that wait together come as 1 digest. A busy chat gets 5 quick messages, then 1 every 30 s. Only 1 message a minute rings. The link works once, within 15 minutes. The chat appears in the webhook list with the URL `telegram:<chat ID>`, with deliveries, retries & resume as any webhook. In the chat, /stop pauses its alerts. It costs no credits.
     *
     * @param list<EventType|value-of<EventType>>|null $eventTypes array of event types to subscribe to
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function createTelegramLink(
        ?array $eventTypes = null,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookCreateTelegramLinkResponse {
        $params = Util::removeNulls(
            [
                'eventTypes' => $eventTypes,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->createTelegramLink(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
