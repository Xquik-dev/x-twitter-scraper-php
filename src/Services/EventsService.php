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
use XTwitterScraper\Events\EventListResponse;
use XTwitterScraper\Events\EventStreamParams\IncludeModel;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\EventsContract;

/**
 * Activity events from monitored accounts.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class EventsService implements EventsContract
{
    /**
     * @api
     */
    public EventsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new EventsRawService($client);
    }

    /**
     * @api
     *
     * Get event
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): EventDetail {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List events
     *
     * @param string $cursor previous nextCursor
     * @param EventType|value-of<EventType> $eventType Filter events by type
     * @param string $keywordMonitorID keyword monitor ID
     * @param int $limit Maximum number of items to return (1-100, default 50). For paid per-result endpoints, the returned count may be lower when remaining credits cannot cover the requested page. If zero paid results are affordable, the endpoint returns 402 insufficient_credits.
     * @param string $monitorID account monitor ID
     * @param string|null $postMonitorID Post monitor ID. The post_monitor_id alias also works.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        EventType|string|null $eventType = null,
        ?string $keywordMonitorID = null,
        int $limit = 50,
        ?string $monitorID = null,
        ?string $postMonitorID = null,
        RequestOptions|array|null $requestOptions = null,
    ): EventListResponse {
        $params = Util::removeNulls(
            ['postMonitorID' => $postMonitorID,
                'cursor' => $cursor,
                'eventType' => $eventType,
                'keywordMonitorID' => $keywordMonitorID,
                'limit' => $limit,
                'monitorID' => $monitorID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Streams the account's monitor events as server-sent events, each named by its event type and numbered by its event ID. A reconnect that sends Last-Event-ID first gets every event after that one from the last 30 days, then each new event. Set lookBack to also get events saved late. A connection lasts up to 30 minutes and sends a comment every 15 seconds while idle. Keep up to 200 streams open per account. Events and streams cost no credits. Add include=post_metrics to also get post.metrics frames. The first poll sends 1 for each post monitor with a check or a pause. After that, a frame comes when a monitor's saved numbers or status change. These frames carry no ID, so Last-Event-ID never moves.
     *
     * @param IncludeModel|value-of<IncludeModel>|null $include Set to post_metrics to also get each post monitor's saved numbers. Any other value is refused.
     * @param bool|null $lookBack Set to true to resume 30 seconds before Last-Event-ID. Events saved late then still arrive. Events you have can arrive again, so skip IDs you've seen. An ID the stream can't find starts 5 minutes back, not 30 days.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function stream(
        IncludeModel|string|null $include = null,
        ?bool $lookBack = null,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        $params = Util::removeNulls(
            [
                'include' => $include,
                'lookBack' => $lookBack,
            ],
        );

        // @phpstan-ignore-next-line return.type
        return $this->raw->stream(params: $params, requestOptions: $requestOptions);
    }
}
