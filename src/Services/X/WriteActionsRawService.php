<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\WriteActionsRawContract;
use XTwitterScraper\X\WriteActions\WriteActionGetResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class WriteActionsRawService implements WriteActionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get write action status
     *
     * @param string $id write action ID returned by a pending write response
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WriteActionGetResponse>
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
            path: ['x/write-actions/%1$s', $id],
            options: $requestOptions,
            convert: WriteActionGetResponse::class,
        );
    }
}
