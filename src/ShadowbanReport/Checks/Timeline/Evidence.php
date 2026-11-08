<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport\Checks\Timeline;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EvidenceShape = array{
 *   postCount: int|null,
 *   timelinePosts: int,
 * }
 */
final class Evidence implements BaseModel
{
    /** @use SdkModel<EvidenceShape> */
    use SdkModel;

    /**
     * Posts X counts on the profile.
     */
    #[Required]
    public ?int $postCount;

    /**
     * Posts the timeline read returned, up to 20.
     */
    #[Required]
    public int $timelinePosts;

    /**
     * `new Evidence()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Evidence::with(postCount: ..., timelinePosts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Evidence)->withPostCount(...)->withTimelinePosts(...)
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
    public static function with(?int $postCount, int $timelinePosts): self
    {
        $self = new self;

        $self['postCount'] = $postCount;
        $self['timelinePosts'] = $timelinePosts;

        return $self;
    }

    /**
     * Posts X counts on the profile.
     */
    public function withPostCount(?int $postCount): self
    {
        $self = clone $this;
        $self['postCount'] = $postCount;

        return $self;
    }

    /**
     * Posts the timeline read returned, up to 20.
     */
    public function withTimelinePosts(int $timelinePosts): self
    {
        $self = clone $this;
        $self['timelinePosts'] = $timelinePosts;

        return $self;
    }
}
