<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\UserInsights;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AveragesShape = array{
 *   likes: float,
 *   replies: float,
 *   reposts: float,
 *   quotes: float,
 *   bookmarks: float,
 *   views: float,
 *   engagements: float,
 * }
 */
final class Averages implements BaseModel
{
    /** @use SdkModel<AveragesShape> */
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
     * Likes, replies, reposts and quotes per post.
     */
    #[Required]
    public float $engagements;

    /**
     * `new Averages()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Averages::with(likes: ..., replies: ..., reposts: ..., quotes: ..., bookmarks: ..., views: ..., engagements: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Averages)->withLikes(...)->withReplies(...)->withReposts(...)->withQuotes(...)->withBookmarks(...)->withViews(...)->withEngagements(...)
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
    public static function with(float $likes, float $replies, float $reposts, float $quotes, float $bookmarks, float $views, float $engagements): self
    {
        $self = new self;

        $self['likes'] = $likes;
        $self['replies'] = $replies;
        $self['reposts'] = $reposts;
        $self['quotes'] = $quotes;
        $self['bookmarks'] = $bookmarks;
        $self['views'] = $views;
        $self['engagements'] = $engagements;

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

    /**
     * Likes, replies, reposts and quotes per post.
     */
    public function withEngagements(float $engagements): self
    {
        $self = clone $this;
        $self['engagements'] = $engagements;

        return $self;
    }
}
