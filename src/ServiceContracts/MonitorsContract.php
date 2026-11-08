<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Monitor;
use XTwitterScraper\Monitors\MonitorDeactivateResponse;
use XTwitterScraper\Monitors\MonitorListResponse;
use XTwitterScraper\Monitors\MonitorNewResponse;
use XTwitterScraper\Monitors\MonitorUpsertByUsernameResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface MonitorsContract
{
    /**
     * @api
     *
     * @param list<EventType|value-of<EventType>> $eventTypes array of event types to subscribe to
     * @param string $username X username (without @)
     * @param string|null $name Your label for the monitor. Its events carry it as monitorName. Xquik normalizes whitespace.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $eventTypes,
        string $username,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): MonitorNewResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
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
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param list<EventType|value-of<EventType>> $eventTypes array of event types to subscribe to
     * @param string|null $name New label for the account monitor. Send null to remove the label.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?array $eventTypes = null,
        ?bool $isActive = null,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): Monitor;

    /**
     * @api
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
    ): MonitorListResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): MonitorDeactivateResponse;

    /**
     * @api
     *
     * @param list<EventType|value-of<EventType>> $eventTypes array of event types to subscribe to
     * @param string|null $name Your label for the monitor. Its events carry it as monitorName. Leave it out to keep the current label, or send null to remove it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function upsertByUsername(
        string $username,
        array $eventTypes,
        ?string $name = null,
        RequestOptions|array|null $requestOptions = null,
    ): MonitorUpsertByUsernameResponse;
}
