<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Jobs;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns job listings with title, location, salary, company & apply link. Add filters to narrow them. A closed job does not appear & costs nothing. Follow next_cursor for more.
 *
 * @see XTwitterScraper\Services\X\JobsService::search()
 *
 * @phpstan-type JobSearchParamsShape = array{
 *   q: string,
 *   location?: string|null,
 *   locationID?: string|null,
 *   locationType?: string|null,
 *   seniority?: string|null,
 *   employmentType?: string|null,
 *   company?: string|null,
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class JobSearchParams implements BaseModel
{
    /** @use SdkModel<JobSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Keyword, such as a job title or skill. Its alias is query. Xquik's cap is 4,096 characters.
     */
    #[Required]
    public string $q;

    /**
     * City, region or country as text, such as Berlin. Xquik's cap is 4,096 characters.
     */
    #[Optional]
    public ?string $location;

    /**
     * Location ID from GET /x/jobs/locations. Replaces location when both are sent.
     */
    #[Optional('locationId')]
    public ?string $locationID;

    /**
     * Where the work happens. Comma-separated list of onsite, remote & hybrid. Any case works. It allows 44 characters for every choice once with spaces, hyphens or underscores.
     */
    #[Optional]
    public ?string $locationType;

    /**
     * Comma-separated list of intern, entry_level, junior, mid_level, senior, lead, manager & executive. Any case works. It allows 144 characters for every choice once with spaces, hyphens or underscores.
     */
    #[Optional]
    public ?string $seniority;

    /**
     * Comma-separated list of full_time, full_time_contract, part_time & contract_to_hire. Any case works. It allows 116 characters for every choice once with spaces, hyphens or underscores.
     */
    #[Optional]
    public ?string $employmentType;

    /**
     * Company name to match. Xquik's cap is 4,096 characters.
     */
    #[Optional]
    public ?string $company;

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    #[Optional]
    public ?string $fields;

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $omit;

    /**
     * `new JobSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JobSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JobSearchParams)->withQ(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $q, ?string $location = null, ?string $locationID = null, ?string $locationType = null, ?string $seniority = null, ?string $employmentType = null, ?string $company = null, ?string $cursor = null, ?int $pageSize = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        $self['q'] = $q;

        null !== $location && $self['location'] = $location;
        null !== $locationID && $self['locationID'] = $locationID;
        null !== $locationType && $self['locationType'] = $locationType;
        null !== $seniority && $self['seniority'] = $seniority;
        null !== $employmentType && $self['employmentType'] = $employmentType;
        null !== $company && $self['company'] = $company;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Keyword, such as a job title or skill. Its alias is query. Xquik's cap is 4,096 characters.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * City, region or country as text, such as Berlin. Xquik's cap is 4,096 characters.
     */
    public function withLocation(?string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * Location ID from GET /x/jobs/locations. Replaces location when both are sent.
     */
    public function withLocationID(?string $locationID): self
    {
        $self = clone $this;
        $self['locationID'] = $locationID;

        return $self;
    }

    /**
     * Where the work happens. Comma-separated list of onsite, remote & hybrid. Any case works. It allows 44 characters for every choice once with spaces, hyphens or underscores.
     */
    public function withLocationType(?string $locationType): self
    {
        $self = clone $this;
        $self['locationType'] = $locationType;

        return $self;
    }

    /**
     * Comma-separated list of intern, entry_level, junior, mid_level, senior, lead, manager & executive. Any case works. It allows 144 characters for every choice once with spaces, hyphens or underscores.
     */
    public function withSeniority(?string $seniority): self
    {
        $self = clone $this;
        $self['seniority'] = $seniority;

        return $self;
    }

    /**
     * Comma-separated list of full_time, full_time_contract, part_time & contract_to_hire. Any case works. It allows 116 characters for every choice once with spaces, hyphens or underscores.
     */
    public function withEmploymentType(?string $employmentType): self
    {
        $self = clone $this;
        $self['employmentType'] = $employmentType;

        return $self;
    }

    /**
     * Company name to match. Xquik's cap is 4,096 characters.
     */
    public function withCompany(?string $company): self
    {
        $self = clone $this;
        $self['company'] = $company;

        return $self;
    }

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    public function withPageSize(?int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    public function withFields(?string $fields): self
    {
        $self = clone $this;
        $self['fields'] = $fields;

        return $self;
    }

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    public function withOmit(?string $omit): self
    {
        $self = clone $this;
        $self['omit'] = $omit;

        return $self;
    }
}
