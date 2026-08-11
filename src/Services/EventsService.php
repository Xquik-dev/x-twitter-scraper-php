<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Events\EventDetail;
use XTwitterScraper\Events\EventListResponse;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\EventsContract;

/**
 * Activity events from monitored accounts.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
        RequestOptions|array|null $requestOptions = null,
    ): EventListResponse {
        $params = Util::removeNulls(
            [
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
}
