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
 * @phpstan-import-type RequestOpts from RequestOptions
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
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function check(
        string $source,
        string $target,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): FollowerCheckResponse {
        $params = Util::removeNulls(['omit' => $omit, 'fields' => $fields, 'source' => $source, 'target' => $target]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->check(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
