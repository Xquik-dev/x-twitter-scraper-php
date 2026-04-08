<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Monitor;
use XTwitterScraper\Monitors\MonitorDeactivateResponse;
use XTwitterScraper\Monitors\MonitorListResponse;
use XTwitterScraper\Monitors\MonitorNewResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface MonitorsContract
{
    /**
     * @api
     *
     * @param list<EventType|value-of<EventType>> $eventTypes array of event types to subscribe to
     * @param string $username X username (without @)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $eventTypes,
        string $username,
        RequestOptions|array|null $requestOptions = null,
    ): MonitorNewResponse;

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
    ): Monitor;

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
        RequestOptions|array|null $requestOptions = null,
    ): Monitor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): MonitorListResponse;

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
    ): MonitorDeactivateResponse;
}
