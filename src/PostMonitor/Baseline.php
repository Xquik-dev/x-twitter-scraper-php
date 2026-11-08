<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitor;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BaselineShape = array{
 *   at: \DateTimeInterface,
 *   views: int|null,
 *   likes: int,
 *   retweets: int,
 *   replies: int,
 *   quotes: int,
 *   bookmarks: int,
 * }
 */
final class Baseline implements BaseModel
{
    /** @use SdkModel<BaselineShape> */
    use SdkModel;

    /**
     * When Xquik read these counts from X.
     */
    #[Required]
    public \DateTimeInterface $at;

    #[Required]
    public ?int $views;

    #[Required]
    public int $likes;

    #[Required]
    public int $retweets;

    #[Required]
    public int $replies;

    #[Required]
    public int $quotes;

    #[Required]
    public int $bookmarks;

    /**
     * `new Baseline()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Baseline::with(at: ..., views: ..., likes: ..., retweets: ..., replies: ..., quotes: ..., bookmarks: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Baseline)->withAt(...)->withViews(...)->withLikes(...)->withRetweets(...)->withReplies(...)->withQuotes(...)->withBookmarks(...)
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
    public static function with(\DateTimeInterface $at, ?int $views, int $likes, int $retweets, int $replies, int $quotes, int $bookmarks): self
    {
        $self = new self;

        $self['at'] = $at;
        $self['views'] = $views;
        $self['likes'] = $likes;
        $self['retweets'] = $retweets;
        $self['replies'] = $replies;
        $self['quotes'] = $quotes;
        $self['bookmarks'] = $bookmarks;

        return $self;
    }

    /**
     * When Xquik read these counts from X.
     */
    public function withAt(\DateTimeInterface $at): self
    {
        $self = clone $this;
        $self['at'] = $at;

        return $self;
    }

    public function withViews(?int $views): self
    {
        $self = clone $this;
        $self['views'] = $views;

        return $self;
    }

    public function withLikes(int $likes): self
    {
        $self = clone $this;
        $self['likes'] = $likes;

        return $self;
    }

    public function withRetweets(int $retweets): self
    {
        $self = clone $this;
        $self['retweets'] = $retweets;

        return $self;
    }

    public function withReplies(int $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    public function withQuotes(int $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    public function withBookmarks(int $bookmarks): self
    {
        $self = clone $this;
        $self['bookmarks'] = $bookmarks;

        return $self;
    }
}
