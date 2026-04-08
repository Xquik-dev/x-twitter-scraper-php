<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DrawListItemShape from \XTwitterScraper\Draws\DrawListItem
 *
 * @phpstan-type DrawListResponseShape = array{
 *   draws: list<DrawListItem|DrawListItemShape>,
 *   hasMore: bool,
 *   nextCursor?: string|null,
 * }
 */
final class DrawListResponse implements BaseModel
{
    /** @use SdkModel<DrawListResponseShape> */
    use SdkModel;

    /** @var list<DrawListItem> $draws */
    #[Required(list: DrawListItem::class)]
    public array $draws;

    #[Required]
    public bool $hasMore;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new DrawListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DrawListResponse::with(draws: ..., hasMore: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DrawListResponse)->withDraws(...)->withHasMore(...)
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
     * @param list<DrawListItem|DrawListItemShape> $draws
     */
    public static function with(
        array $draws,
        bool $hasMore,
        ?string $nextCursor = null
    ): self {
        $self = new self;

        $self['draws'] = $draws;
        $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<DrawListItem|DrawListItemShape> $draws
     */
    public function withDraws(array $draws): self
    {
        $self = clone $this;
        $self['draws'] = $draws;

        return $self;
    }

    public function withHasMore(bool $hasMore): self
    {
        $self = clone $this;
        $self['hasMore'] = $hasMore;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
