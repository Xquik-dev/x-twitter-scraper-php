<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\EventType;
use XTwitterScraper\Integrations\Integration;
use XTwitterScraper\Integrations\IntegrationCreateParams\Config;
use XTwitterScraper\Integrations\IntegrationCreateParams\Type;
use XTwitterScraper\Integrations\IntegrationDeleteResponse;
use XTwitterScraper\Integrations\IntegrationListDeliveriesResponse;
use XTwitterScraper\Integrations\IntegrationListResponse;
use XTwitterScraper\Integrations\IntegrationSendTestResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\IntegrationsContract;

/**
 * Push notification integrations (Telegram).
 *
 * @phpstan-import-type ConfigShape from \XTwitterScraper\Integrations\IntegrationCreateParams\Config
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class IntegrationsService implements IntegrationsContract
{
    /**
     * @api
     */
    public IntegrationsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new IntegrationsRawService($client);
    }

    /**
     * @api
     *
     * Create integration
     *
     * @param Config|ConfigShape $config Integration config (e.g. Telegram chatId)
     * @param list<EventType|value-of<EventType>> $eventTypes
     * @param Type|value-of<Type> $type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        Config|array $config,
        array $eventTypes,
        string $name,
        Type|string $type,
        RequestOptions|array|null $requestOptions = null,
    ): Integration {
        $params = Util::removeNulls(
            [
                'config' => $config,
                'eventTypes' => $eventTypes,
                'name' => $name,
                'type' => $type,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get integration details
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): Integration {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update integration
     *
     * @param string $id Resource ID (stringified bigint)
     * @param list<EventType|value-of<EventType>> $eventTypes
     * @param array<string,mixed> $filters
     * @param array<string,mixed> $messageTemplate
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?array $eventTypes = null,
        ?array $filters = null,
        ?bool $isActive = null,
        ?array $messageTemplate = null,
        ?string $name = null,
        ?bool $scopeAllMonitors = null,
        ?bool $silentPush = null,
        RequestOptions|array|null $requestOptions = null,
    ): Integration {
        $params = Util::removeNulls(
            [
                'eventTypes' => $eventTypes,
                'filters' => $filters,
                'isActive' => $isActive,
                'messageTemplate' => $messageTemplate,
                'name' => $name,
                'scopeAllMonitors' => $scopeAllMonitors,
                'silentPush' => $silentPush,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List integrations
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): IntegrationListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete integration
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): IntegrationDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List integration delivery history
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): IntegrationListDeliveriesResponse {
        $params = Util::removeNulls(['limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listDeliveries($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Send test delivery
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendTest(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): IntegrationSendTestResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->sendTest($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
