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
 * @phpstan-type SampleShape = array{
 *   posts: float,
 *   read: float,
 *   oldestAt: \DateTimeInterface|null,
 *   newestAt: \DateTimeInterface|null,
 * }
 */
final class Sample implements BaseModel
{
    /** @use SdkModel<SampleShape> */
    use SdkModel;

    /**
     * Posts the averages used. Reposts and the pinned post stay out, so this can be lower than `read`.
     */
    #[Required]
    public float $posts;

    /**
     * Posts read, reposts and the pinned post included.
     */
    #[Required]
    public float $read;

    /**
     * When the oldest post the averages used went up.
     */
    #[Required]
    public ?\DateTimeInterface $oldestAt;

    /**
     * When the newest post the averages used went up.
     */
    #[Required]
    public ?\DateTimeInterface $newestAt;

    /**
     * `new Sample()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Sample::with(posts: ..., read: ..., oldestAt: ..., newestAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Sample)->withPosts(...)->withRead(...)->withOldestAt(...)->withNewestAt(...)
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
    public static function with(float $posts, float $read, ?\DateTimeInterface $oldestAt, ?\DateTimeInterface $newestAt): self
    {
        $self = new self;

        $self['posts'] = $posts;
        $self['read'] = $read;
        $self['oldestAt'] = $oldestAt;
        $self['newestAt'] = $newestAt;

        return $self;
    }

    /**
     * Posts the averages used. Reposts and the pinned post stay out, so this can be lower than `read`.
     */
    public function withPosts(float $posts): self
    {
        $self = clone $this;
        $self['posts'] = $posts;

        return $self;
    }

    /**
     * Posts read, reposts and the pinned post included.
     */
    public function withRead(float $read): self
    {
        $self = clone $this;
        $self['read'] = $read;

        return $self;
    }

    /**
     * When the oldest post the averages used went up.
     */
    public function withOldestAt(?\DateTimeInterface $oldestAt): self
    {
        $self = clone $this;
        $self['oldestAt'] = $oldestAt;

        return $self;
    }

    /**
     * When the newest post the averages used went up.
     */
    public function withNewestAt(?\DateTimeInterface $newestAt): self
    {
        $self = clone $this;
        $self['newestAt'] = $newestAt;

        return $self;
    }
}
