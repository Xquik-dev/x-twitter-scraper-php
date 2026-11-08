<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\PostMonitorMetrics\Buckets;

/**
 * @phpstan-type PostMonitorMetricsShape = array{
 *   hours: int,
 *   buckets: list<Buckets|array<string,mixed>>,
 * }
 */
final class PostMonitorMetrics implements BaseModel
{
    /** @use SdkModel<PostMonitorMetricsShape> */
    use SdkModel;

    #[Required]
    public int $hours;

    /**
     * @var list<Buckets> $buckets
     */
    #[Required(list: Buckets::class)]
    public array $buckets;

    /**
     * `new PostMonitorMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostMonitorMetrics::with(hours: ..., buckets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostMonitorMetrics)->withHours(...)->withBuckets(...)
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
     * @param list<Buckets|array<string,mixed>> $buckets
     */
    public static function with(int $hours, array $buckets): self
    {
        $self = new self;

        $self['hours'] = $hours;
        $self['buckets'] = $buckets;

        return $self;
    }

    public function withHours(int $hours): self
    {
        $self = clone $this;
        $self['hours'] = $hours;

        return $self;
    }

    /**
     * @param list<Buckets|array<string,mixed>> $buckets
     */
    public function withBuckets(array $buckets): self
    {
        $self = clone $this;
        $self['buckets'] = $buckets;

        return $self;
    }
}
