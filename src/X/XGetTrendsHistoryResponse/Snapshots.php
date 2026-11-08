<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\XGetTrendsHistoryResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetTrendsHistoryResponse\Snapshots\Trends;

/**
 * @phpstan-type SnapshotsShape = array{
 *   capturedAt: \DateTimeInterface,
 *   count: int,
 *   trends: list<Trends|array<string,mixed>>,
 * }
 */
final class Snapshots implements BaseModel
{
    /** @use SdkModel<SnapshotsShape> */
    use SdkModel;

    /**
     * When Xquik read this stored list from X. Xquik never estimates it.
     */
    #[Required]
    public \DateTimeInterface $capturedAt;

    /**
     * Trends in this list.
     */
    #[Required]
    public int $count;

    /**
     * @var list<Trends> $trends
     */
    #[Required(list: Trends::class)]
    public array $trends;

    /**
     * `new Snapshots()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Snapshots::with(capturedAt: ..., count: ..., trends: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Snapshots)->withCapturedAt(...)->withCount(...)->withTrends(...)
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
     * @param list<Trends|array<string,mixed>> $trends
     */
    public static function with(\DateTimeInterface $capturedAt, int $count, array $trends): self
    {
        $self = new self;

        $self['capturedAt'] = $capturedAt;
        $self['count'] = $count;
        $self['trends'] = $trends;

        return $self;
    }

    /**
     * When Xquik read this stored list from X. Xquik never estimates it.
     */
    public function withCapturedAt(\DateTimeInterface $capturedAt): self
    {
        $self = clone $this;
        $self['capturedAt'] = $capturedAt;

        return $self;
    }

    /**
     * Trends in this list.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * @param list<Trends|array<string,mixed>> $trends
     */
    public function withTrends(array $trends): self
    {
        $self = clone $this;
        $self['trends'] = $trends;

        return $self;
    }
}
