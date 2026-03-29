<?php

declare(strict_types=1);

namespace XTwitterScraper\Drafts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Drafts\DraftListResponse\Draft;

/**
 * @phpstan-import-type DraftShape from \XTwitterScraper\Drafts\DraftListResponse\Draft
 *
 * @phpstan-type DraftListResponseShape = array{
 *   drafts: list<Draft|DraftShape>, hasMore: bool, nextCursor?: string|null
 * }
 */
final class DraftListResponse implements BaseModel
{
    /** @use SdkModel<DraftListResponseShape> */
    use SdkModel;

    /** @var list<Draft> $drafts */
    #[Required(list: Draft::class)]
    public array $drafts;

    #[Required]
    public bool $hasMore;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new DraftListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DraftListResponse::with(drafts: ..., hasMore: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DraftListResponse)->withDrafts(...)->withHasMore(...)
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
     * @param list<Draft|DraftShape> $drafts
     */
    public static function with(
        array $drafts,
        bool $hasMore,
        ?string $nextCursor = null
    ): self {
        $self = new self;

        $self['drafts'] = $drafts;
        $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<Draft|DraftShape> $drafts
     */
    public function withDrafts(array $drafts): self
    {
        $self = clone $this;
        $self['drafts'] = $drafts;

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
