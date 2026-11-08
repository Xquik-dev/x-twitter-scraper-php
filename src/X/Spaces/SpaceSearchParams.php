<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Spaces;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Spaces\SpaceSearchParams\QueryType;

/**
 * Returns public Spaces, each once, with the fields of GET /x/spaces/{id}. Latest & Top find live, scheduled or ended Spaces & accept X search operators. Live & Upcoming find live or scheduled Spaces by title words. Costs 1 credit per Space.
 *
 * @see XTwitterScraper\Services\X\SpacesService::search()
 *
 * @phpstan-type SpaceSearchParamsShape = array{
 *   q: string,
 *   queryType?: QueryType|value-of<QueryType>|null,
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class SpaceSearchParams implements BaseModel
{
    /** @use SdkModel<SpaceSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Words, hashtags or X search operators, such as from:solana. Live & Upcoming match title words only, without operators. Alias query.
     */
    #[Required]
    public string $q;

    /**
     * Latest finds Spaces in the newest posts. Top finds them in the most engaging posts. Live lists Spaces on air now. Upcoming lists scheduled ones, as X's Spaces search does. Any case works. Aliases result_type, sort_order, type, search_type, product, category & section.
     *
     * @var value-of<QueryType>|null $queryType
     */
    #[Optional(enum: QueryType::class)]
    public ?string $queryType;

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * For Latest & Top, the page size (1-100, default 20). A page can return fewer Spaces. Send 100 to read a search fastest. For Live & Upcoming, the most Spaces a page returns. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
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
     * `new SpaceSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpaceSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpaceSearchParams)->withQ(...)
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
     *
     * @param QueryType|value-of<QueryType>|null $queryType
     */
    public static function with(string $q, QueryType|string|null $queryType = null, ?string $cursor = null, ?int $pageSize = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        $self['q'] = $q;

        null !== $queryType && $self['queryType'] = $queryType;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Words, hashtags or X search operators, such as from:solana. Live & Upcoming match title words only, without operators. Alias query.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Latest finds Spaces in the newest posts. Top finds them in the most engaging posts. Live lists Spaces on air now. Upcoming lists scheduled ones, as X's Spaces search does. Any case works. Aliases result_type, sort_order, type, search_type, product, category & section.
     *
     * @param QueryType|value-of<QueryType>|null $queryType
     */
    public function withQueryType(QueryType|string|null $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

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
     * For Latest & Top, the page size (1-100, default 20). A page can return fewer Spaces. Send 100 to read a search fastest. For Live & Upcoming, the most Spaces a page returns. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
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
