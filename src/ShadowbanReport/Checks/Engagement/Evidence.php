<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Engagement;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EvidenceShape = array{
 *   newestMedian: float,
 *   newestPosts: int,
 *   earlierMedian: float,
 *   earlierPosts: int,
 * }
 */
final class Evidence implements BaseModel
{
    /** @use SdkModel<EvidenceShape> */
    use SdkModel;

    /**
     * Median engagement of the newest posts.
     */
    #[Required]
    public float $newestMedian;

    /**
     * Posts in the newest group, up to 5.
     */
    #[Required]
    public int $newestPosts;

    /**
     * Median engagement of the earlier posts.
     */
    #[Required]
    public float $earlierMedian;

    /**
     * Posts in the earlier group.
     */
    #[Required]
    public int $earlierPosts;

    /**
     * `new Evidence()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Evidence::with(newestMedian: ..., newestPosts: ..., earlierMedian: ..., earlierPosts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Evidence)->withNewestMedian(...)->withNewestPosts(...)->withEarlierMedian(...)->withEarlierPosts(...)
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
    public static function with(float $newestMedian, int $newestPosts, float $earlierMedian, int $earlierPosts): self
    {
        $self = new self;

        $self['newestMedian'] = $newestMedian;
        $self['newestPosts'] = $newestPosts;
        $self['earlierMedian'] = $earlierMedian;
        $self['earlierPosts'] = $earlierPosts;

        return $self;
    }

    /**
     * Median engagement of the newest posts.
     */
    public function withNewestMedian(float $newestMedian): self
    {
        $self = clone $this;
        $self['newestMedian'] = $newestMedian;

        return $self;
    }

    /**
     * Posts in the newest group, up to 5.
     */
    public function withNewestPosts(int $newestPosts): self
    {
        $self = clone $this;
        $self['newestPosts'] = $newestPosts;

        return $self;
    }

    /**
     * Median engagement of the earlier posts.
     */
    public function withEarlierMedian(float $earlierMedian): self
    {
        $self = clone $this;
        $self['earlierMedian'] = $earlierMedian;

        return $self;
    }

    /**
     * Posts in the earlier group.
     */
    public function withEarlierPosts(int $earlierPosts): self
    {
        $self = clone $this;
        $self['earlierPosts'] = $earlierPosts;

        return $self;
    }
}
