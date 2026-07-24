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
use XTwitterScraper\ServiceContracts\X\FollowersRawContract;
use XTwitterScraper\X\Followers\FollowerCheckParams;
use XTwitterScraper\X\Followers\FollowerCheckResponse;

/**
 * Look up, search, and explore user profiles and relationships.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class FollowersRawService implements FollowersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Check if one user follows another
     *
     * @param array{source: string, target: string}|FollowerCheckParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowerCheckResponse>
     *
     * @throws APIException
     */
    public function check(
        array|FollowerCheckParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FollowerCheckParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/followers/check',
            query: $parsed,
            options: $options,
            convert: FollowerCheckResponse::class,
        );
    }
}
