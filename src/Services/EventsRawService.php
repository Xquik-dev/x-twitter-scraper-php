<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Events\EventDetail;
use XTwitterScraper\Events\EventListParams;
use XTwitterScraper\Events\EventListResponse;
use XTwitterScraper\Events\EventStreamParams;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\EventsRawContract;

/**
 * Activity events from monitored accounts.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class EventsRawService implements EventsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get event
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EventDetail>
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
            path: ['events/%1$s', $id],
            options: $requestOptions,
            convert: EventDetail::class,
        );
    }

    /**
     * @api
     *
     * List events
     *
     * @param array{
     *   cursor?: string,
     *   eventType?: value-of<EventType>,
     *   keywordMonitorID?: string,
     *   limit?: int,
     *   monitorID?: string,
     * }|EventListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EventListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|EventListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EventListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'events',
            query: Util::array_transform_keys(
                $parsed,
                ['keywordMonitorID' => 'keywordMonitorId', 'monitorID' => 'monitorId'],
            ),
            options: $options,
            convert: EventListResponse::class,
        );
    }

    /**
     * @api
     *
     * Streams the account's monitor events as server-sent events, each named by its event type and numbered by its event ID. A reconnect that sends Last-Event-ID first gets every event after that one from the last 30 days, then each new event. Set lookBack to also get events saved late. A connection lasts up to 30 minutes and sends a comment every 15 seconds while idle. Keep up to 200 streams open per account. Events and streams cost no credits. Add include=post_metrics to also get post.metrics frames. The first poll sends 1 for each post monitor with a check or a pause. After that, a frame comes when a monitor's saved numbers or status change. These frames carry no ID, so Last-Event-ID never moves.
     *
     * @param array<string,mixed>|EventStreamParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function stream(
        array|EventStreamParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EventStreamParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'events/stream',
            query: $parsed,
            headers: ['Accept' => 'text/event-stream'],
            options: $options,
            convert: 'string',
        );
    }
}
