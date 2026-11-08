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
use XTwitterScraper\Monitors\Monitor;
use XTwitterScraper\Monitors\MonitorDeactivateResponse;
use XTwitterScraper\Monitors\MonitorListResponse;
use XTwitterScraper\Monitors\MonitorNewResponse;
use XTwitterScraper\Monitors\MonitorUpsertByUsernameResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\MonitorsContract;
use XTwitterScraper\Services\Monitors\KeywordsService;
use XTwitterScraper\Services\Monitors\PostsService;

/**
 * X account monitoring with 1-second checks.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class MonitorsService implements MonitorsContract
{
    /**
     * @api
     */
    public MonitorsRawService $raw;

    /**
     * @api
     */
    public KeywordsService $keywords;

    /**
     * @api
     */
    public PostsService $posts;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MonitorsRawService($client);
        $this->posts = new PostsService($client);
        $this->keywords = new KeywordsService($client);
    }

    /**
     * @api
     *
     * Creates an account monitor. Monitors are unlimited. Active monitors check every 1 second and cost 30 credits per hour. Events and webhook deliveries are included. Creation requires available credits for the first hourly charge and username lookup.
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
    ): MonitorNewResponse {
        $params = Util::removeNulls(
            ['name' => $name, 'eventTypes' => $eventTypes, 'username' => $username]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): Monitor {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update monitor
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
    ): Monitor {
        $params = Util::removeNulls(
            ['name' => $name, 'eventTypes' => $eventTypes, 'isActive' => $isActive]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List monitors
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
    ): MonitorListResponse {
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
     * Delete monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): MonitorDeactivateResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deactivate($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Creates the monitor if it does not exist, or updates it if it does. Send the same call twice & you still have 1 monitor. A new monitor answers 201 & an update answers 200. Both carry `created`, so you know which one ran. Creating needs the credits of the first hour, then costs 30 credits an hour. A stopped monitor turns back on & counts as created. Updating is free & replaces the event types. It changes the name only when you send one.
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
    ): MonitorUpsertByUsernameResponse {
        $params = Util::removeNulls(
            [
                'eventTypes' => $eventTypes,
                'name' => $name,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->upsertByUsername($username, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
