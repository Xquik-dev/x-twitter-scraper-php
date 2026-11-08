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
use XTwitterScraper\ServiceContracts\X\BroadcastsRawContract;
use XTwitterScraper\X\Broadcasts\BroadcastRetrieveParams;
use XTwitterScraper\X\Broadcasts\BroadcastRetrieveResponse;

/**
 * Broadcast operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class BroadcastsRawService implements BroadcastsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns 1 X broadcast, the live video X hosts at x.com/i/broadcasts, live or ended. Accepts the broadcast ID or the URL-encoded broadcast URL. Reading a broadcast adds no view to it.
     *
     * @param array<string,mixed>|BroadcastRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastRetrieveResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|BroadcastRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BroadcastRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/broadcasts/%1$s', $id],
            query: $parsed,
            options: $options,
            convert: BroadcastRetrieveResponse::class,
        );
    }
}
