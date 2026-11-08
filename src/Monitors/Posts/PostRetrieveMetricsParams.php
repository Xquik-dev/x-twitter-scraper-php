<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Monitors\Posts;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Returns 1 bucket per hour with each metric's value at the hour's end & its gain over that hour. The last bucket is the current hour. Hours before tracking began carry the starting values with a gain of 0.
 *
 * @see XTwitterScraper\Services\Monitors\PostsService::retrieveMetrics()
 *
 * @phpstan-type PostRetrieveMetricsParamsShape = array{
 *   hours?: int|null,
 * }
 */
final class PostRetrieveMetricsParams implements BaseModel
{
    /** @use SdkModel<PostRetrieveMetricsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Hours to return, from 1 to 17,520.
     */
    #[Optional]
    public ?int $hours;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $hours = null): self
    {
        $self = new self;

        null !== $hours && $self['hours'] = $hours;

        return $self;
    }

    /**
     * Hours to return, from 1 to 17,520.
     */
    public function withHours(?int $hours): self
    {
        $self = clone $this;
        $self['hours'] = $hours;

        return $self;
    }
}
