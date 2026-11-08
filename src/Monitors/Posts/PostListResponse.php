<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Posts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PostMonitor;

/**
 * @phpstan-type PostListResponseShape = array{
 *   monitors: list<PostMonitor|array<string,mixed>>,
 *   total: int,
 *   hasMore: bool,
 *   nextCursor?: string|null,
 * }
 */
final class PostListResponse implements BaseModel
{
    /** @use SdkModel<PostListResponseShape> */
    use SdkModel;

    /**
     * @var list<PostMonitor> $monitors
     */
    #[Required(list: PostMonitor::class)]
    public array $monitors;

    /**
     * Post monitors on this page.
     */
    #[Required]
    public int $total;

    #[Required]
    public bool $hasMore;

    #[Optional]
    public ?string $nextCursor;

    /**
     * `new PostListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostListResponse::with(monitors: ..., total: ..., hasMore: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostListResponse)->withMonitors(...)->withTotal(...)->withHasMore(...)
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
     * @param list<PostMonitor|array<string,mixed>> $monitors
     */
    public static function with(array $monitors, int $total, bool $hasMore, ?string $nextCursor = null): self
    {
        $self = new self;

        $self['monitors'] = $monitors;
        $self['total'] = $total;
        $self['hasMore'] = $hasMore;

        null !== $nextCursor && $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<PostMonitor|array<string,mixed>> $monitors
     */
    public function withMonitors(array $monitors): self
    {
        $self = clone $this;
        $self['monitors'] = $monitors;

        return $self;
    }

    /**
     * Post monitors on this page.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    public function withHasMore(bool $hasMore): self
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
