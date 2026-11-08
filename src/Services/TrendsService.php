<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\TrendsContract;
use XTwitterScraper\Trends\TrendListResponse;

/**
 * Trending topics and hashtags by region.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class TrendsService implements TrendsContract
{
    /**
     * @api
     */
    public TrendsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TrendsRawService($client);
    }

    /**
     * @api
     *
     * Get trending hashtags and topics by region (alias)
     *
     * @param int $count Number of trending topics returned (1-50, default 30)
     * @param int $woeid Region Yahoo WOEID code (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey)
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        int $count = 30,
        int $woeid = 1,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): TrendListResponse {
        $params = Util::removeNulls(['omit' => $omit, 'fields' => $fields, 'count' => $count, 'woeid' => $woeid]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
