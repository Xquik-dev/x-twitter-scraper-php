<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Trends;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get trending hashtags and topics by region (alias).
 *
 * @see XTwitterScraper\Services\TrendsService::list()
 *
 * @phpstan-type TrendListParamsShape = array{count?: int|null, woeid?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class TrendListParams implements BaseModel
{
    /** @use SdkModel<TrendListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Number of trending topics returned (1-50, default 30).
     */
    #[Optional]
    public ?int $count;

    /**
     * Region Yahoo WOEID code (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey).
     */
    #[Optional]
    public ?int $woeid;

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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $count = null, ?int $woeid = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $count && $self['count'] = $count;
        null !== $woeid && $self['woeid'] = $woeid;

        null !== $fields && $self['fields'] = $fields;

        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Number of trending topics returned (1-50, default 30).
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Region Yahoo WOEID code (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey).
     */
    public function withWoeid(int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

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
