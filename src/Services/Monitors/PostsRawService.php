<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\Monitors;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Monitors\Posts\PostCreateParams;
use XTwitterScraper\Monitors\Posts\PostDeleteResponse;
use XTwitterScraper\Monitors\Posts\PostListParams;
use XTwitterScraper\Monitors\Posts\PostListResponse;
use XTwitterScraper\Monitors\Posts\PostRetrieveMetricsParams;
use XTwitterScraper\Monitors\Posts\PostUpdateParams;
use XTwitterScraper\PostMonitor;
use XTwitterScraper\PostMonitorMetrics;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Monitors\PostsRawContract;

/**
 * Post operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class PostsRawService implements PostsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns post monitors with each post's 6 metrics, their current values & gains since tracking began.
     *
     * @param array<string,mixed>|PostListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PostListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|PostListParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PostListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'monitors/posts',
            query: $parsed,
            options: $options,
            convert: PostListResponse::class,
        );
    }

    /**
     * @api
     *
     * Creates a monitor for 1 X post. It tracks replies, quotes, edits, deletion & 6 metrics, for 30 credits an hour with events & webhook deliveries included. That hourly price is a monitor's only charge. Creation needs the credits of the first hour & reads the post once.
     *
     * @param array<string,mixed>|PostCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PostMonitor>
     *
     * @throws APIException
     */
    public function create(
        array|PostCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PostCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'monitors/posts',
            body: (object) $parsed,
            options: $options,
            convert: PostMonitor::class,
        );
    }

    /**
     * @api
     *
     * Returns 1 post monitor with its post & the 6 metrics, each with its current value & gain since tracking began.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PostMonitor>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['monitors/posts/%1$s', $id],
            options: $requestOptions,
            convert: PostMonitor::class,
        );
    }

    /**
     * @api
     *
     * Stops 1 post monitor, then removes its stored events & metric history in bounded batches. Poll statusUrl until the monitor returns 404.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PostDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['monitors/posts/%1$s', $id],
            options: $requestOptions,
            convert: PostDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Updates a post monitor's label, event types or active state. Turning a paused monitor on reads the post first, & answers 409 while X hides it.
     *
     * @param array<string,mixed>|PostUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PostMonitor>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|PostUpdateParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PostUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['monitors/posts/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: PostMonitor::class,
        );
    }

    /**
     * @api
     *
     * Returns 1 bucket per hour with each metric's value at the hour's end & its gain over that hour. The last bucket is the current hour. Hours before tracking began carry the starting values with a gain of 0.
     *
     * @param array<string,mixed>|PostRetrieveMetricsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PostMonitorMetrics>
     *
     * @throws APIException
     */
    public function retrieveMetrics(
        string $id,
        array|PostRetrieveMetricsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PostRetrieveMetricsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['monitors/posts/%1$s/metrics', $id],
            query: $parsed,
            options: $options,
            convert: PostMonitorMetrics::class,
        );
    }
}
