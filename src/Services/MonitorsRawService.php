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
use XTwitterScraper\Monitors\Monitor;
use XTwitterScraper\Monitors\MonitorCreateParams;
use XTwitterScraper\Monitors\MonitorDeactivateResponse;
use XTwitterScraper\Monitors\MonitorListParams;
use XTwitterScraper\Monitors\MonitorListResponse;
use XTwitterScraper\Monitors\MonitorNewResponse;
use XTwitterScraper\Monitors\MonitorUpdateParams;
use XTwitterScraper\Monitors\MonitorUpsertByUsernameParams;
use XTwitterScraper\Monitors\MonitorUpsertByUsernameResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\MonitorsRawContract;

/**
 * X account monitoring with 1-second checks.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class MonitorsRawService implements MonitorsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates an account monitor. Monitors are unlimited. Active monitors check every 1 second and cost 30 credits per hour. Events and webhook deliveries are included. Creation requires available credits for the first hourly charge and username lookup.
     *
     * @param array{
     *   eventTypes: list<EventType|value-of<EventType>>, username: string
     * }|MonitorCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|MonitorCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MonitorCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'monitors',
            body: (object) $parsed,
            options: $options,
            convert: MonitorNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Monitor>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['monitors/%1$s', $id],
            options: $requestOptions,
            convert: Monitor::class,
        );
    }

    /**
     * @api
     *
     * Update monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param array{
     *   eventTypes?: list<EventType|value-of<EventType>>, isActive?: bool
     * }|MonitorUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Monitor>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|MonitorUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MonitorUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['monitors/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: Monitor::class,
        );
    }

    /**
     * @api
     *
     * List monitors
     *
     * @param array<string,mixed>|MonitorListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|MonitorListParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = MonitorListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'monitors',
            query: $parsed,
            options: $options,
            convert: MonitorListResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorDeactivateResponse>
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
            path: ['monitors/%1$s', $id],
            options: $requestOptions,
            convert: MonitorDeactivateResponse::class,
        );
    }

    /**
     * @api
     *
     * Creates the monitor if it does not exist, or updates it if it does. Send the same call twice & you still have 1 monitor. A new monitor answers 201 & an update answers 200. Both carry `created`, so you know which one ran. Creating needs the credits of the first hour, then costs 30 credits an hour. A stopped monitor turns back on & counts as created. Updating is free & replaces the event types. It changes the name only when you send one.
     *
     * @param array<string,mixed>|MonitorUpsertByUsernameParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorUpsertByUsernameResponse>
     *
     * @throws APIException
     */
    public function upsertByUsername(
        string $username,
        array|MonitorUpsertByUsernameParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MonitorUpsertByUsernameParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: ['monitors/username/%1$s', $username],
            body: (object) $parsed,
            options: $options,
            convert: MonitorUpsertByUsernameResponse::class,
        );
    }
}
