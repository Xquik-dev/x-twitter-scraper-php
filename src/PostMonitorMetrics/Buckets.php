<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\PostMonitorMetrics;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PostMonitorMetrics\Buckets\Metrics;

/**
 * @phpstan-type BucketsShape = array{
 *   at: \DateTimeInterface,
 *   metrics: Metrics|array<string,mixed>,
 * }
 */
final class Buckets implements BaseModel
{
    /** @use SdkModel<BucketsShape> */
    use SdkModel;

    /**
     * Start of the hour.
     */
    #[Required]
    public \DateTimeInterface $at;

    #[Required]
    public Metrics $metrics;

    /**
     * `new Buckets()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Buckets::with(at: ..., metrics: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Buckets)->withAt(...)->withMetrics(...)
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
     * @param Metrics|array<string,mixed> $metrics
     */
    public static function with(\DateTimeInterface $at, Metrics|array $metrics): self
    {
        $self = new self;

        $self['at'] = $at;
        $self['metrics'] = $metrics;

        return $self;
    }

    /**
     * Start of the hour.
     */
    public function withAt(\DateTimeInterface $at): self
    {
        $self = clone $this;
        $self['at'] = $at;

        return $self;
    }

    /**
     * @param Metrics|array<string,mixed> $metrics
     */
    public function withMetrics(Metrics|array $metrics): self
    {
        $self = clone $this;
        $self['metrics'] = $metrics;

        return $self;
    }
}
