<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Sports;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Sports\SportListPostsParams\QueryType;

/**
 * Returns a game's top or latest posts, plus an X search you can run for more. Works before, during & after the game. Pages hold up to 20 posts, & each post costs 1 credit.
 *
 * @see XTwitterScraper\Services\X\SportsService::listPosts()
 *
 * @phpstan-type SportListPostsParamsShape = array{
 *   queryType?: QueryType|value-of<QueryType>|null,
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class SportListPostsParams implements BaseModel
{
    /** @use SdkModel<SportListPostsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Top for the posts X ranks highest, or Latest for the newest. Any case works, & so do Relevance & Recency. Alias order or sort. Send the same value with each cursor.
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
    public static function with(QueryType|string|null $queryType = null, ?string $cursor = null, ?int $pageSize = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $queryType && $self['queryType'] = $queryType;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Top for the posts X ranks highest, or Latest for the newest. Any case works, & so do Relevance & Recency. Alias order or sort. Send the same value with each cursor.
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
