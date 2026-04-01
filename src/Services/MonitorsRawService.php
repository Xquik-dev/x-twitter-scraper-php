<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Monitors\MonitorCreateParams;
use XTwitterScraper\Monitors\MonitorCreateParams\EventType;
use XTwitterScraper\Monitors\MonitorDeactivateResponse;
use XTwitterScraper\Monitors\MonitorGetResponse;
use XTwitterScraper\Monitors\MonitorListResponse;
use XTwitterScraper\Monitors\MonitorNewResponse;
use XTwitterScraper\Monitors\MonitorUpdateParams;
use XTwitterScraper\Monitors\MonitorUpdateResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\MonitorsRawContract;

/**
 * Real-time X account monitoring.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * Create monitor
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
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorGetResponse>
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
            convert: MonitorGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update monitor
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{
     *   eventTypes?: list<MonitorUpdateParams\EventType|value-of<MonitorUpdateParams\EventType>>,
     *   isActive?: bool,
     * }|MonitorUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorUpdateResponse>
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
            convert: MonitorUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List monitors
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MonitorListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'monitors',
            options: $requestOptions,
            convert: MonitorListResponse::class,
        );
    }

    /**
     * @api
     *
     * Deactivate monitor
     *
     * @param string $id Resource ID (stringified bigint)
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
}
