<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Spaces\SpaceRetrieveReplayResponse;
use XTwitterScraper\X\Spaces\SpaceRetrieveResponse;
use XTwitterScraper\X\Spaces\SpaceSearchParams\QueryType;
use XTwitterScraper\X\Spaces\SpaceSearchResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface SpacesContract
{
    /**
     * @api
     *
     * @param string $q Words, hashtags or X search operators, such as from:solana. Live & Upcoming match title words only, without operators. Alias query.
     * @param QueryType|value-of<QueryType>|null $queryType Latest finds Spaces in the newest posts. Top finds them in the most engaging posts. Live lists Spaces on air now. Upcoming lists scheduled ones, as X's Spaces search does. Any case works. Aliases result_type, sort_order, type, search_type, product, category & section.
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize For Latest & Top, the page size (1-100, default 20). A page can return fewer Spaces. Send 100 to read a search fastest. For Live & Upcoming, the most Spaces a page returns. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function search(
        string $q,
        QueryType|string|null $queryType = null,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): SpaceSearchResponse;

    /**
     * @api
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): SpaceRetrieveResponse;

    /**
     * @api
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveReplay(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): SpaceRetrieveReplayResponse;
}
