<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Webhooks\Webhook;
use XTwitterScraper\Webhooks\WebhookDeactivateResponse;
use XTwitterScraper\Webhooks\WebhookListDeliveriesResponse;
use XTwitterScraper\Webhooks\WebhookListResponse;
use XTwitterScraper\Webhooks\WebhookNewResponse;
use XTwitterScraper\Webhooks\WebhookTestResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface WebhooksContract
{
    /**
     * @api
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
    ): WebhookNewResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
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
    ): Webhook;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): WebhookListResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): WebhookDeactivateResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): WebhookListDeliveriesResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): WebhookTestResponse;
}
