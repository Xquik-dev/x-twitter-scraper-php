<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\JobLocations;
use XTwitterScraper\PaginatedJobs;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Jobs\JobRetrieveResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface JobsContract
{
    /**
     * @api
     *
     * @param string $q Keyword, such as a job title or skill. Its alias is query. Xquik's cap is 4,096 characters.
     * @param string|null $location City, region or country as text, such as Berlin. Xquik's cap is 4,096 characters.
     * @param string|null $locationID Location ID from GET /x/jobs/locations. Replaces location when both are sent.
     * @param string|null $locationType Where the work happens. Comma-separated list of onsite, remote & hybrid. Any case works. It allows 44 characters for every choice once with spaces, hyphens or underscores.
     * @param string|null $seniority Comma-separated list of intern, entry_level, junior, mid_level, senior, lead, manager & executive. Any case works. It allows 144 characters for every choice once with spaces, hyphens or underscores.
     * @param string|null $employmentType Comma-separated list of full_time, full_time_contract, part_time & contract_to_hire. Any case works. It allows 116 characters for every choice once with spaces, hyphens or underscores.
     * @param string|null $company Company name to match. Xquik's cap is 4,096 characters.
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function search(
        string $q,
        ?string $location = null,
        ?string $locationID = null,
        ?string $locationType = null,
        ?string $seniority = null,
        ?string $employmentType = null,
        ?string $company = null,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedJobs;

    /**
     * @api
     *
     * @param string $q Place name or its start, such as new york. Its alias is query. Xquik's cap is 4,096 characters.
     * @param int|null $limit Most places to return. Without it, every match returns. Its aliases are pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listLocations(
        string $q,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): JobLocations;

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
    ): JobRetrieveResponse;
}
