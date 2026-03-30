<?php

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
     * @param string $id Resource ID (stringified bigint)
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
    ): EventListResponse {
        $params = Util::removeNulls(
            [
                'after' => $after,
                'eventType' => $eventType,
                'limit' => $limit,
                'monitorID' => $monitorID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
