<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Monitors;

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

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface PostsRawContract
{
    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
