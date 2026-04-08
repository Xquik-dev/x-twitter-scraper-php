<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\EventType;
use XTwitterScraper\Integrations\Integration;
use XTwitterScraper\Integrations\IntegrationCreateParams;
use XTwitterScraper\Integrations\IntegrationCreateParams\Config;
use XTwitterScraper\Integrations\IntegrationDeleteResponse;
use XTwitterScraper\Integrations\IntegrationListDeliveriesParams;
use XTwitterScraper\Integrations\IntegrationListDeliveriesResponse;
use XTwitterScraper\Integrations\IntegrationListResponse;
use XTwitterScraper\Integrations\IntegrationSendTestResponse;
use XTwitterScraper\Integrations\IntegrationUpdateParams;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\IntegrationsRawContract;

/**
 * Push notification integrations (Telegram).
 *
 * @phpstan-import-type ConfigShape from \XTwitterScraper\Integrations\IntegrationCreateParams\Config
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class IntegrationsRawService implements IntegrationsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create integration
     *
     * @param array{
     *   config: Config|ConfigShape,
     *   eventTypes: list<EventType|value-of<EventType>>,
     *   name: string,
     *   type?: 'telegram',
     * }|IntegrationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Integration>
     *
     * @throws APIException
     */
    public function create(
        array|IntegrationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IntegrationCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'integrations',
            body: (object) $parsed,
            options: $options,
            convert: Integration::class,
        );
    }

    /**
     * @api
     *
     * Get integration details
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Integration>
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
            path: ['integrations/%1$s', $id],
            options: $requestOptions,
            convert: Integration::class,
        );
    }

    /**
     * @api
     *
     * Update integration
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{
     *   eventTypes?: list<EventType|value-of<EventType>>,
     *   filters?: array<string,mixed>,
     *   isActive?: bool,
     *   messageTemplate?: array<string,mixed>,
     *   name?: string,
     *   scopeAllMonitors?: bool,
     *   silentPush?: bool,
     * }|IntegrationUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Integration>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|IntegrationUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IntegrationUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['integrations/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: Integration::class,
        );
    }

    /**
     * @api
     *
     * List integrations
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'integrations',
            options: $requestOptions,
            convert: IntegrationListResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete integration
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['integrations/%1$s', $id],
            options: $requestOptions,
            convert: IntegrationDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * List integration delivery history
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{limit?: int}|IntegrationListDeliveriesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationListDeliveriesResponse>
     *
     * @throws APIException
     */
    public function listDeliveries(
        string $id,
        array|IntegrationListDeliveriesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IntegrationListDeliveriesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['integrations/%1$s/deliveries', $id],
            query: $parsed,
            options: $options,
            convert: IntegrationListDeliveriesResponse::class,
        );
    }

    /**
     * @api
     *
     * Send test delivery
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntegrationSendTestResponse>
     *
     * @throws APIException
     */
    public function sendTest(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['integrations/%1$s/test', $id],
            options: $requestOptions,
            convert: IntegrationSendTestResponse::class,
        );
    }
}
