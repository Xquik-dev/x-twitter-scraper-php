<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Events\EventDetail;
use XTwitterScraper\Events\EventListResponse;
use XTwitterScraper\Events\EventStreamParams\IncludeModel;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface EventsContract
{
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
    ): EventDetail;

    /**
     * @api
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
    ): EventListResponse;

    /**
     * @api
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
    ): BaseResponse;
}
