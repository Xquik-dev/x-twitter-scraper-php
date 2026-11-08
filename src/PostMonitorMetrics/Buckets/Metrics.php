<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitorMetrics\Buckets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PostMetricPoint;

/**
 * @phpstan-type MetricsShape = array{
 *   views: PostMetricPoint|array<string,mixed>,
 *   likes: PostMetricPoint|array<string,mixed>,
 *   retweets: PostMetricPoint|array<string,mixed>,
 *   replies: PostMetricPoint|array<string,mixed>,
 *   quotes: PostMetricPoint|array<string,mixed>,
 *   bookmarks: PostMetricPoint|array<string,mixed>,
 * }
 */
final class Metrics implements BaseModel
{
    /** @use SdkModel<MetricsShape> */
    use SdkModel;

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     */
    #[Required]
    public PostMetricPoint $views;

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     */
    #[Required]
    public PostMetricPoint $likes;

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     */
    #[Required]
    public PostMetricPoint $retweets;

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     */
    #[Required]
    public PostMetricPoint $replies;

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     */
    #[Required]
    public PostMetricPoint $quotes;

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     */
    #[Required]
    public PostMetricPoint $bookmarks;

    /**
     * `new Metrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Metrics::with(views: ..., likes: ..., retweets: ..., replies: ..., quotes: ..., bookmarks: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Metrics)->withViews(...)->withLikes(...)->withRetweets(...)->withReplies(...)->withQuotes(...)->withBookmarks(...)
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
     * @param PostMetricPoint|array<string,mixed> $views
     * @param PostMetricPoint|array<string,mixed> $likes
     * @param PostMetricPoint|array<string,mixed> $retweets
     * @param PostMetricPoint|array<string,mixed> $replies
     * @param PostMetricPoint|array<string,mixed> $quotes
     * @param PostMetricPoint|array<string,mixed> $bookmarks
     */
    public static function with(PostMetricPoint|array $views, PostMetricPoint|array $likes, PostMetricPoint|array $retweets, PostMetricPoint|array $replies, PostMetricPoint|array $quotes, PostMetricPoint|array $bookmarks): self
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
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     *
     * @param PostMetricPoint|array<string,mixed> $views
     */
    public function withViews(PostMetricPoint|array $views): self
    {
        $self = clone $this;
        $self['views'] = $views;

        return $self;
    }

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     *
     * @param PostMetricPoint|array<string,mixed> $likes
     */
    public function withLikes(PostMetricPoint|array $likes): self
    {
        $self = clone $this;
        $self['likes'] = $likes;

        return $self;
    }

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     *
     * @param PostMetricPoint|array<string,mixed> $retweets
     */
    public function withRetweets(PostMetricPoint|array $retweets): self
    {
        $self = clone $this;
        $self['retweets'] = $retweets;

        return $self;
    }

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     *
     * @param PostMetricPoint|array<string,mixed> $replies
     */
    public function withReplies(PostMetricPoint|array $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     *
     * @param PostMetricPoint|array<string,mixed> $quotes
     */
    public function withQuotes(PostMetricPoint|array $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    /**
     * A metric's value at the hour's end & its gain over that hour. Both are null when X shows no count.
     *
     * @param PostMetricPoint|array<string,mixed> $bookmarks
     */
    public function withBookmarks(PostMetricPoint|array $bookmarks): self
    {
        $self = clone $this;
        $self['bookmarks'] = $bookmarks;

        return $self;
    }
}
