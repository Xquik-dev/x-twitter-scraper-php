<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Integrations\IntegrationCreateParams\Config;
use XTwitterScraper\Integrations\IntegrationCreateParams\EventType;
use XTwitterScraper\Integrations\IntegrationCreateParams\Type;
use XTwitterScraper\Integrations\IntegrationDeleteResponse;
use XTwitterScraper\Integrations\IntegrationGetResponse;
use XTwitterScraper\Integrations\IntegrationListDeliveriesResponse;
use XTwitterScraper\Integrations\IntegrationListResponse;
use XTwitterScraper\Integrations\IntegrationNewResponse;
use XTwitterScraper\Integrations\IntegrationSendTestResponse;
use XTwitterScraper\Integrations\IntegrationUpdateResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type ConfigShape from \XTwitterScraper\Integrations\IntegrationCreateParams\Config
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface IntegrationsContract
{
    /**
     * @api
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
    ): IntegrationNewResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): IntegrationGetResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param list<\XTwitterScraper\Integrations\IntegrationUpdateParams\EventType|value-of<\XTwitterScraper\Integrations\IntegrationUpdateParams\EventType>> $eventTypes
     * @param array<string,mixed> $filters Event filter rules (JSON)
     * @param array<string,mixed> $messageTemplate Custom message template (JSON)
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
    ): IntegrationUpdateResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): IntegrationListResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): IntegrationDeleteResponse;

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
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): IntegrationListDeliveriesResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sendTest(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): IntegrationSendTestResponse;
}
