<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type StyleProfileSummaryShape from StyleProfileSummary
 *
 * @phpstan-type StyleListResponseShape = array{
 *   styles: list<StyleProfileSummary|StyleProfileSummaryShape>,
 *   hasMore?: bool|null,
 *   nextCursor?: string|null,
 * }
 */
final class StyleListResponse implements BaseModel
{
    /** @use SdkModel<StyleListResponseShape> */
    use SdkModel;

    /** @var list<StyleProfileSummary> $styles */
    #[Required(list: StyleProfileSummary::class)]
    public array $styles;

    #[Optional]
    public ?bool $hasMore;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new StyleListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleListResponse::with(styles: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleListResponse)->withStyles(...)
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
     * @param list<StyleProfileSummary|StyleProfileSummaryShape> $styles
     */
    public static function with(array $styles, ?bool $hasMore = null, ?string $nextCursor = null): self
    {
        $self = new self;

        $self['styles'] = $styles;

        null !== $hasMore && $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<StyleProfileSummary|StyleProfileSummaryShape> $styles
     */
    public function withStyles(array $styles): self
    {
        $self = clone $this;
        $self['styles'] = $styles;

        return $self;
    }

    public function withHasMore(?bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    public function withNextCursor(?string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
