<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Monitors;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Keywords\KeywordDeactivateResponse;
use XTwitterScraper\Monitors\Keywords\KeywordGetResponse;
use XTwitterScraper\Monitors\Keywords\KeywordListResponse;
use XTwitterScraper\Monitors\Keywords\KeywordNewResponse;
use XTwitterScraper\Monitors\Keywords\KeywordUpdateResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Monitors\KeywordsContract;

/**
 * Real-time X account monitoring.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class KeywordsService implements KeywordsContract
{
    /**
     * @api
     */
    public KeywordsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new KeywordsRawService($client);
    }

    /**
     * @api
     *
     * Creates an instant keyword monitor. Keyword monitors are unlimited. Active monitors check every 1 second and cost 21 credits per hour. Events and webhook deliveries are included. Creation requires available credits for the first hourly charge.
     *
     * @param list<EventType|value-of<EventType>> $eventTypes array of event types to subscribe to
     * @param string $query X search query to monitor. Whitespace is normalized.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $eventTypes,
        string $query,
        RequestOptions|array|null $requestOptions = null,
    ): KeywordNewResponse {
        $params = Util::removeNulls(
            ['eventTypes' => $eventTypes, 'query' => $query]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get keyword monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): KeywordGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update keyword monitor
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
    ): KeywordUpdateResponse {
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
     * List keyword monitors
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): KeywordListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete keyword monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deactivate(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): KeywordDeactivateResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->deactivate($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
