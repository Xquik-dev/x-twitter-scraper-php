<?php

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
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\MonitorsContract;
use XTwitterScraper\Services\Monitors\KeywordsService;

/**
 * Real-time X account monitoring.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new MonitorsRawService($client);
        $this->keywords = new KeywordsService($client);
    }

    /**
     * @api
     *
     * Creates an instant monitor. Monitors are unlimited. Active monitors check every 1 second and cost 21 credits per hour. Events and webhook deliveries are included. Creation requires available credits for the first hourly charge and username lookup.
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
    ): MonitorNewResponse {
        $params = Util::removeNulls(
            ['eventTypes' => $eventTypes, 'username' => $username]
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        ?array $eventTypes = null,
        ?bool $isActive = null,
        RequestOptions|array|null $requestOptions = null,
    ): Monitor {
        $params = Util::removeNulls(
            ['eventTypes' => $eventTypes, 'isActive' => $isActive]
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): MonitorListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

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
}
