<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Events\EventDetail;
use XTwitterScraper\Events\EventListResponse;
use XTwitterScraper\EventType;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface EventsContract
{
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
    ): EventDetail;

    /**
     * @api
     *
     * @param string $after Cursor for pagination
     * @param EventType|value-of<EventType> $eventType
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $after = null,
        EventType|string|null $eventType = null,
        int $limit = 50,
        ?string $monitorID = null,
        RequestOptions|array|null $requestOptions = null,
    ): EventListResponse;
}
