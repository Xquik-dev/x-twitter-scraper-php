<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\WebhooksContract;
use XTwitterScraper\Webhooks\Webhook;
use XTwitterScraper\Webhooks\WebhookDeactivateResponse;
use XTwitterScraper\Webhooks\WebhookListDeliveriesResponse;
use XTwitterScraper\Webhooks\WebhookListResponse;
use XTwitterScraper\Webhooks\WebhookNewResponse;
use XTwitterScraper\Webhooks\WebhookTestResponse;

/**
 * Webhook endpoint management & delivery.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param list<EventType|value-of<EventType>> $eventTypes
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
     * @param string $id Resource ID (stringified bigint)
     * @param list<EventType|value-of<EventType>> $eventTypes
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): WebhookListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Deactivate webhook
     *
     * @param string $id Resource ID (stringified bigint)
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
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): WebhookListDeliveriesResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listDeliveries($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Test webhook endpoint
     *
     * @param string $id Resource ID (stringified bigint)
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
}
