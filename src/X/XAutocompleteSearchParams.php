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
 * Returns the accounts, topics, hashtags & cashtags X suggests while someone types a search. X may rank them differently per request. Costs 1 credit per suggestion.
 *
 * @see XTwitterScraper\Services\XService::autocompleteSearch()
 *
 * @phpstan-type XAutocompleteSearchParamsShape = array{
 *   q: string,
 *   types?: string|null,
 *   limit?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class XAutocompleteSearchParams implements BaseModel
{
    /** @use SdkModel<XAutocompleteSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Text typed so far. Start with # for hashtags or $ for cashtags. A # query returns hashtags & the accounts X suggests for it. Its alias is query. Xquik's cap is 4,096 characters.
     */
    #[Required]
    public string $q;

    /**
     * Comma-separated suggestion types from users, topics, hashtags & cashtags. Omit for all. With only hashtags or only cashtags, a query without # or $ still works. Any case works. It allows 66 characters for every choice once with spaces around commas.
     */
    #[Optional]
    public ?string $types;

    /**
     * Most suggestions to return, from 1 to 100. Default 20. Accounts fill it first, then topics, hashtags & cashtags. A low credit balance can return fewer. Its aliases are pageSize, count, max_results, maxItems, max_items & per_page.
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
     * `new XAutocompleteSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XAutocompleteSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XAutocompleteSearchParams)->withQ(...)
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
    public static function with(string $q, ?string $types = null, ?int $limit = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        $self['q'] = $q;

        null !== $types && $self['types'] = $types;
        null !== $limit && $self['limit'] = $limit;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Text typed so far. Start with # for hashtags or $ for cashtags. A # query returns hashtags & the accounts X suggests for it. Its alias is query. Xquik's cap is 4,096 characters.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Comma-separated suggestion types from users, topics, hashtags & cashtags. Omit for all. With only hashtags or only cashtags, a query without # or $ still works. Any case works. It allows 66 characters for every choice once with spaces around commas.
     */
    public function withTypes(?string $types): self
    {
        $self = clone $this;
        $self['types'] = $types;

        return $self;
    }

    /**
     * Most suggestions to return, from 1 to 100. Default 20. Accounts fill it first, then topics, hashtags & cashtags. A low credit balance can return fewer. Its aliases are pageSize, count, max_results, maxItems, max_items & per_page.
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
