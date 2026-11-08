<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FollowerAudit;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CohortsShape = array{
 *   count: int,
 *   likelyFake: int,
 *   percent: float,
 *   weekStartMs: int,
 * }
 */
final class Cohorts implements BaseModel
{
    /** @use SdkModel<CohortsShape> */
    use SdkModel;

    #[Required]
    public int $count;

    #[Required]
    public int $likelyFake;

    #[Required]
    public float $percent;

    #[Required]
    public int $weekStartMs;

    /**
     * `new Cohorts()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Cohorts::with(count: ..., likelyFake: ..., percent: ..., weekStartMs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Cohorts)->withCount(...)->withLikelyFake(...)->withPercent(...)->withWeekStartMs(...)
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
    public static function with(int $count, int $likelyFake, float $percent, int $weekStartMs): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['likelyFake'] = $likelyFake;
        $self['percent'] = $percent;
        $self['weekStartMs'] = $weekStartMs;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    public function withLikelyFake(int $likelyFake): self
    {
        $self = clone $this;
        $self['likelyFake'] = $likelyFake;

        return $self;
    }

    public function withPercent(float $percent): self
    {
        $self = clone $this;
        $self['percent'] = $percent;

        return $self;
    }

    public function withWeekStartMs(int $weekStartMs): self
    {
        $self = clone $this;
        $self['weekStartMs'] = $weekStartMs;

        return $self;
    }
}
