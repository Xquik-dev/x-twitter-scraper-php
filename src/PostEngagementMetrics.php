<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PostEngagementMetricsShape = array{
 *   likes: float,
 *   replies: float,
 *   reposts: float,
 *   quotes: float,
 *   bookmarks: float,
 *   views: float,
 * }
 */
final class PostEngagementMetrics implements BaseModel
{
    /** @use SdkModel<PostEngagementMetricsShape> */
    use SdkModel;

    /**
     * Likes.
     */
    #[Required]
    public float $likes;

    /**
     * Replies.
     */
    #[Required]
    public float $replies;

    /**
     * Reposts.
     */
    #[Required]
    public float $reposts;

    /**
     * Quotes.
     */
    #[Required]
    public float $quotes;

    /**
     * Bookmarks.
     */
    #[Required]
    public float $bookmarks;

    /**
     * Views.
     */
    #[Required]
    public float $views;

    /**
     * `new PostEngagementMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostEngagementMetrics::with(likes: ..., replies: ..., reposts: ..., quotes: ..., bookmarks: ..., views: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostEngagementMetrics)->withLikes(...)->withReplies(...)->withReposts(...)->withQuotes(...)->withBookmarks(...)->withViews(...)
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
    public static function with(float $likes, float $replies, float $reposts, float $quotes, float $bookmarks, float $views): self
    {
        $self = new self;

        $self['likes'] = $likes;
        $self['replies'] = $replies;
        $self['reposts'] = $reposts;
        $self['quotes'] = $quotes;
        $self['bookmarks'] = $bookmarks;
        $self['views'] = $views;

        return $self;
    }

    /**
     * Likes.
     */
    public function withLikes(float $likes): self
    {
        $self = clone $this;
        $self['likes'] = $likes;

        return $self;
    }

    /**
     * Replies.
     */
    public function withReplies(float $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * Reposts.
     */
    public function withReposts(float $reposts): self
    {
        $self = clone $this;
        $self['reposts'] = $reposts;

        return $self;
    }

    /**
     * Quotes.
     */
    public function withQuotes(float $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    /**
     * Bookmarks.
     */
    public function withBookmarks(float $bookmarks): self
    {
        $self = clone $this;
        $self['bookmarks'] = $bookmarks;

        return $self;
    }

    /**
     * Views.
     */
    public function withViews(float $views): self
    {
        $self = clone $this;
        $self['views'] = $views;

        return $self;
    }
}
