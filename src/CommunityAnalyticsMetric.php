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
 * @phpstan-type CommunityAnalyticsMetricShape = array{
 *   count: int,
 *   changePercent: float,
 * }
 */
final class CommunityAnalyticsMetric implements BaseModel
{
    /** @use SdkModel<CommunityAnalyticsMetricShape> */
    use SdkModel;

    /**
     * Total for this metric during X's latest period.
     */
    #[Required]
    public int $count;

    /**
     * Change in percent from the same figure 1 day earlier. Values stay unrounded.
     */
    #[Required]
    public float $changePercent;

    /**
     * `new CommunityAnalyticsMetric()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityAnalyticsMetric::with(count: ..., changePercent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityAnalyticsMetric)->withCount(...)->withChangePercent(...)
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
    public static function with(int $count, float $changePercent): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['changePercent'] = $changePercent;

        return $self;
    }

    /**
     * Total for this metric during X's latest period.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Change in percent from the same figure 1 day earlier. Values stay unrounded.
     */
    public function withChangePercent(float $changePercent): self
    {
        $self = clone $this;
        $self['changePercent'] = $changePercent;

        return $self;
    }
}
