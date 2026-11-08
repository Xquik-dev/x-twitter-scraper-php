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
 * @phpstan-type PostMetricsShape = array{
 *   views: PostMetricReading|array<string,mixed>,
 *   likes: PostMetricReading|array<string,mixed>,
 *   retweets: PostMetricReading|array<string,mixed>,
 *   replies: PostMetricReading|array<string,mixed>,
 *   quotes: PostMetricReading|array<string,mixed>,
 *   bookmarks: PostMetricReading|array<string,mixed>,
 * }
 */
final class PostMetrics implements BaseModel
{
    /** @use SdkModel<PostMetricsShape> */
    use SdkModel;

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     */
    #[Required]
    public PostMetricReading $views;

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     */
    #[Required]
    public PostMetricReading $likes;

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     */
    #[Required]
    public PostMetricReading $retweets;

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     */
    #[Required]
    public PostMetricReading $replies;

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     */
    #[Required]
    public PostMetricReading $quotes;

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     */
    #[Required]
    public PostMetricReading $bookmarks;

    /**
     * `new PostMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostMetrics::with(views: ..., likes: ..., retweets: ..., replies: ..., quotes: ..., bookmarks: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostMetrics)->withViews(...)->withLikes(...)->withRetweets(...)->withReplies(...)->withQuotes(...)->withBookmarks(...)
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
     * @param PostMetricReading|array<string,mixed> $views
     * @param PostMetricReading|array<string,mixed> $likes
     * @param PostMetricReading|array<string,mixed> $retweets
     * @param PostMetricReading|array<string,mixed> $replies
     * @param PostMetricReading|array<string,mixed> $quotes
     * @param PostMetricReading|array<string,mixed> $bookmarks
     */
    public static function with(PostMetricReading|array $views, PostMetricReading|array $likes, PostMetricReading|array $retweets, PostMetricReading|array $replies, PostMetricReading|array $quotes, PostMetricReading|array $bookmarks): self
    {
        $self = new self;

        $self['views'] = $views;
        $self['likes'] = $likes;
        $self['retweets'] = $retweets;
        $self['replies'] = $replies;
        $self['quotes'] = $quotes;
        $self['bookmarks'] = $bookmarks;

        return $self;
    }

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     *
     * @param PostMetricReading|array<string,mixed> $views
     */
    public function withViews(PostMetricReading|array $views): self
    {
        $self = clone $this;
        $self['views'] = $views;

        return $self;
    }

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     *
     * @param PostMetricReading|array<string,mixed> $likes
     */
    public function withLikes(PostMetricReading|array $likes): self
    {
        $self = clone $this;
        $self['likes'] = $likes;

        return $self;
    }

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     *
     * @param PostMetricReading|array<string,mixed> $retweets
     */
    public function withRetweets(PostMetricReading|array $retweets): self
    {
        $self = clone $this;
        $self['retweets'] = $retweets;

        return $self;
    }

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     *
     * @param PostMetricReading|array<string,mixed> $replies
     */
    public function withReplies(PostMetricReading|array $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     *
     * @param PostMetricReading|array<string,mixed> $quotes
     */
    public function withQuotes(PostMetricReading|array $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    /**
     * A metric's current value & its gain since tracking began. Both are null when X shows no count, as for views on old posts.
     *
     * @param PostMetricReading|array<string,mixed> $bookmarks
     */
    public function withBookmarks(PostMetricReading|array $bookmarks): self
    {
        $self = clone $this;
        $self['bookmarks'] = $bookmarks;

        return $self;
    }
}
