<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns X's hashflags, the custom emoji X shows after some hashtags. Lists the ones running now unless activeOnly is false. Each returned hashflag costs 1 credit.
 *
 * @see XTwitterScraper\Services\XService::getHashflags()
 *
 * @phpstan-type XGetHashflagsParamsShape = array{
 *   q?: string|null,
 *   activeOnly?: bool|null,
 *   limit?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class XGetHashflagsParams implements BaseModel
{
    /** @use SdkModel<XGetHashflagsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Text the hashtag contains, such as football. Case insensitive. A leading hash sign is ignored. Alias query. A post holds at most 280 characters.
     */
    #[Optional]
    public ?string $q;

    /**
     * Keeps hashflags that run now. Send false to add ended & upcoming ones.
     */
    #[Optional]
    public ?bool $activeOnly;

    /**
     * Maximum hashflags to return. Omit it for every match. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
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

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $q = null, ?bool $activeOnly = null, ?int $limit = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $q && $self['q'] = $q;
        null !== $activeOnly && $self['activeOnly'] = $activeOnly;
        null !== $limit && $self['limit'] = $limit;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Text the hashtag contains, such as football. Case insensitive. A leading hash sign is ignored. Alias query. A post holds at most 280 characters.
     */
    public function withQ(?string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Keeps hashflags that run now. Send false to add ended & upcoming ones.
     */
    public function withActiveOnly(?bool $activeOnly): self
    {
        $self = clone $this;
        $self['activeOnly'] = $activeOnly;

        return $self;
    }

    /**
     * Maximum hashflags to return. Omit it for every match. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
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
