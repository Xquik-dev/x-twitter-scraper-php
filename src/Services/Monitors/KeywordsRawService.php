<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Monitors;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\EventType;
use XTwitterScraper\Monitors\Keywords\KeywordCreateParams;
use XTwitterScraper\Monitors\Keywords\KeywordDeactivateResponse;
use XTwitterScraper\Monitors\Keywords\KeywordGetResponse;
use XTwitterScraper\Monitors\Keywords\KeywordListResponse;
use XTwitterScraper\Monitors\Keywords\KeywordNewResponse;
use XTwitterScraper\Monitors\Keywords\KeywordUpdateParams;
use XTwitterScraper\Monitors\Keywords\KeywordUpdateResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Monitors\KeywordsRawContract;

/**
 * Real-time X account monitoring.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class KeywordsRawService implements KeywordsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Creates an instant keyword monitor. Keyword monitors are unlimited. Active monitors check every 1 second and cost 21 credits per hour. Events and webhook deliveries are included. Creation requires available credits for the first hourly charge.
     *
     * @param array{
     *   eventTypes: list<EventType|value-of<EventType>>, query: string
     * }|KeywordCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KeywordNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|KeywordCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = KeywordCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'monitors/keywords',
            body: (object) $parsed,
            options: $options,
            convert: KeywordNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get keyword monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KeywordGetResponse>
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
            path: ['monitors/keywords/%1$s', $id],
            options: $requestOptions,
            convert: KeywordGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update keyword monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param array{
     *   eventTypes?: list<EventType|value-of<EventType>>, isActive?: bool
     * }|KeywordUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KeywordUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|KeywordUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = KeywordUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['monitors/keywords/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: KeywordUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List keyword monitors
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KeywordListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'monitors/keywords',
            options: $requestOptions,
            convert: KeywordListResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete keyword monitor
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KeywordDeactivateResponse>
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
            path: ['monitors/keywords/%1$s', $id],
            options: $requestOptions,
            convert: KeywordDeactivateResponse::class,
        );
    }
}
