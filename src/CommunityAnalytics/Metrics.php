<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\CommunityAnalytics;

use XTwitterScraper\CommunityAnalyticsMetric;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type MetricsShape = array{
 *   likes: CommunityAnalyticsMetric|array<string,mixed>,
 *   newMembers: CommunityAnalyticsMetric|array<string,mixed>,
 *   posts: CommunityAnalyticsMetric|array<string,mixed>,
 *   replies: CommunityAnalyticsMetric|array<string,mixed>,
 *   uniquePosters: CommunityAnalyticsMetric|array<string,mixed>,
 * }
 */
final class Metrics implements BaseModel
{
    /** @use SdkModel<MetricsShape> */
    use SdkModel;

    /**
     * A community metric for X's latest period & its percent change.
     */
    #[Required]
    public CommunityAnalyticsMetric $likes;

    /**
     * A community metric for X's latest period & its percent change.
     */
    #[Required]
    public CommunityAnalyticsMetric $newMembers;

    /**
     * A community metric for X's latest period & its percent change.
     */
    #[Required]
    public CommunityAnalyticsMetric $posts;

    /**
     * A community metric for X's latest period & its percent change.
     */
    #[Required]
    public CommunityAnalyticsMetric $replies;

    /**
     * A community metric for X's latest period & its percent change.
     */
    #[Required]
    public CommunityAnalyticsMetric $uniquePosters;

    /**
     * `new Metrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Metrics::with(likes: ..., newMembers: ..., posts: ..., replies: ..., uniquePosters: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Metrics)->withLikes(...)->withNewMembers(...)->withPosts(...)->withReplies(...)->withUniquePosters(...)
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
     * @param CommunityAnalyticsMetric|array<string,mixed> $likes
     * @param CommunityAnalyticsMetric|array<string,mixed> $newMembers
     * @param CommunityAnalyticsMetric|array<string,mixed> $posts
     * @param CommunityAnalyticsMetric|array<string,mixed> $replies
     * @param CommunityAnalyticsMetric|array<string,mixed> $uniquePosters
     */
    public static function with(CommunityAnalyticsMetric|array $likes, CommunityAnalyticsMetric|array $newMembers, CommunityAnalyticsMetric|array $posts, CommunityAnalyticsMetric|array $replies, CommunityAnalyticsMetric|array $uniquePosters): self
    {
        $self = new self;

        $self['likes'] = $likes;
        $self['newMembers'] = $newMembers;
        $self['posts'] = $posts;
        $self['replies'] = $replies;
        $self['uniquePosters'] = $uniquePosters;

        return $self;
    }

    /**
     * A community metric for X's latest period & its percent change.
     *
     * @param CommunityAnalyticsMetric|array<string,mixed> $likes
     */
    public function withLikes(CommunityAnalyticsMetric|array $likes): self
    {
        $self = clone $this;
        $self['likes'] = $likes;

        return $self;
    }

    /**
     * A community metric for X's latest period & its percent change.
     *
     * @param CommunityAnalyticsMetric|array<string,mixed> $newMembers
     */
    public function withNewMembers(CommunityAnalyticsMetric|array $newMembers): self
    {
        $self = clone $this;
        $self['newMembers'] = $newMembers;

        return $self;
    }

    /**
     * A community metric for X's latest period & its percent change.
     *
     * @param CommunityAnalyticsMetric|array<string,mixed> $posts
     */
    public function withPosts(CommunityAnalyticsMetric|array $posts): self
    {
        $self = clone $this;
        $self['posts'] = $posts;

        return $self;
    }

    /**
     * A community metric for X's latest period & its percent change.
     *
     * @param CommunityAnalyticsMetric|array<string,mixed> $replies
     */
    public function withReplies(CommunityAnalyticsMetric|array $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * A community metric for X's latest period & its percent change.
     *
     * @param CommunityAnalyticsMetric|array<string,mixed> $uniquePosters
     */
    public function withUniquePosters(CommunityAnalyticsMetric|array $uniquePosters): self
    {
        $self = clone $this;
        $self['uniquePosters'] = $uniquePosters;

        return $self;
    }
}
