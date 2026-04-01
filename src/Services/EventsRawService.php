<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Events\EventGetResponse;
use XTwitterScraper\Events\EventListParams;
use XTwitterScraper\Events\EventListParams\EventType;
use XTwitterScraper\Events\EventListResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\EventsRawContract;

/**
 * Activity events from monitored accounts.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<EventGetResponse>
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
            convert: EventGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List events
     *
     * @param array{
     *   after?: string,
     *   eventType?: value-of<EventType>,
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
            query: Util::array_transform_keys($parsed, ['monitorID' => 'monitorId']),
            options: $options,
            convert: EventListResponse::class,
            security: ['apiKey' => true],
        );
    }
}
