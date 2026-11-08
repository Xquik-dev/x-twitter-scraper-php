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
 * Returns the places whose names match a query, each with the location ID that GET /x/jobs/search takes. No match returns an empty list, free.
 *
 * @see XTwitterScraper\Services\X\JobsService::listLocations()
 *
 * @phpstan-type JobListLocationsParamsShape = array{
 *   q: string,
 *   limit?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class JobListLocationsParams implements BaseModel
{
    /** @use SdkModel<JobListLocationsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Place name or its start, such as new york. Its alias is query. Xquik's cap is 4,096 characters.
     */
    #[Required]
    public string $q;

    /**
     * Most places to return. Without it, every match returns. Its aliases are pageSize, count, max_results, maxItems, max_items & per_page.
     */
    #[Optional]
    public ?int $limit;

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
     * `new JobListLocationsParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * JobListLocationsParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new JobListLocationsParams)->withQ(...)
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
    public static function with(string $q, ?int $limit = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        $self['q'] = $q;

        null !== $limit && $self['limit'] = $limit;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Place name or its start, such as new york. Its alias is query. Xquik's cap is 4,096 characters.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Most places to return. Without it, every match returns. Its aliases are pageSize, count, max_results, maxItems, max_items & per_page.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
