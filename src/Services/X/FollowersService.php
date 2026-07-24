<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\FollowersContract;
use XTwitterScraper\X\Followers\FollowerCheckResponse;

/**
 * Look up, search, and explore user profiles and relationships.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class FollowersService implements FollowersContract
{
    /**
     * @api
     */
    public FollowersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new FollowersRawService($client);
    }

    /**
     * @api
     *
     * Check if one user follows another
     *
     * @param string $source Source username, @username, or X or Twitter profile URL
     * @param string $target Target username, @username, or X or Twitter profile URL
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function check(
        string $source,
        string $target,
        RequestOptions|array|null $requestOptions = null,
    ): FollowerCheckResponse {
        $params = Util::removeNulls(['source' => $source, 'target' => $target]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->check(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
