<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Monitors;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Monitors\Keywords\KeywordCreateParams;
use XTwitterScraper\Monitors\Keywords\KeywordDeactivateResponse;
use XTwitterScraper\Monitors\Keywords\KeywordGetResponse;
use XTwitterScraper\Monitors\Keywords\KeywordListResponse;
use XTwitterScraper\Monitors\Keywords\KeywordNewResponse;
use XTwitterScraper\Monitors\Keywords\KeywordUpdateParams;
use XTwitterScraper\Monitors\Keywords\KeywordUpdateResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface KeywordsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|KeywordCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KeywordNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|KeywordCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param array<string,mixed>|KeywordUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KeywordListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
