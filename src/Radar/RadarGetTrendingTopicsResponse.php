<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Radar;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type RadarItemShape from \XTwitterScraper\Radar\RadarItem
 *
 * @phpstan-type RadarGetTrendingTopicsResponseShape = array{
 *   hasMore: bool, items: list<RadarItem|RadarItemShape>, nextCursor?: string|null
 * }
 */
final class RadarGetTrendingTopicsResponse implements BaseModel
{
    /** @use SdkModel<RadarGetTrendingTopicsResponseShape> */
    use SdkModel;

    #[Required]
    public bool $hasMore;

    /** @var list<RadarItem> $items */
    #[Required(list: RadarItem::class)]
    public array $items;

    /**
     * Opaque cursor for the next page (present only when hasMore is true).
     */
    #[Optional]
    public ?string $nextCursor;

    /**
     * `new RadarGetTrendingTopicsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RadarGetTrendingTopicsResponse::with(hasMore: ..., items: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RadarGetTrendingTopicsResponse)->withHasMore(...)->withItems(...)
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
     * @param list<RadarItem|RadarItemShape> $items
     */
    public static function with(
        bool $hasMore,
        array $items,
        ?string $nextCursor = null
    ): self {
        $self = new self;

        $self['hasMore'] = $hasMore;
        $self['items'] = $items;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    public function withHasMore(bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    /**
     * @param list<RadarItem|RadarItemShape> $items
     */
    public function withItems(array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }

    /**
     * Opaque cursor for the next page (present only when hasMore is true).
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
