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
 * @phpstan-type ArrivalBandsShape = array{
 *   count: int,
 *   from: int,
 *   percent: float,
 *   read: int,
 *   to: int,
 * }
 */
final class ArrivalBands implements BaseModel
{
    /** @use SdkModel<ArrivalBandsShape> */
    use SdkModel;

    #[Required]
    public int $count;

    #[Required]
    public int $from;

    #[Required]
    public float $percent;

    #[Required]
    public int $read;

    #[Required]
    public int $to;

    /**
     * `new ArrivalBands()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ArrivalBands::with(count: ..., from: ..., percent: ..., read: ..., to: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ArrivalBands)->withCount(...)->withFrom(...)->withPercent(...)->withRead(...)->withTo(...)
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
    public static function with(int $count, int $from, float $percent, int $read, int $to): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['from'] = $from;
        $self['percent'] = $percent;
        $self['read'] = $read;
        $self['to'] = $to;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    public function withFrom(int $from): self
    {
        $self = clone $this;
        $self['from'] = $from;

        return $self;
    }

    public function withPercent(float $percent): self
    {
        $self = clone $this;
        $self['percent'] = $percent;

        return $self;
    }

    public function withRead(int $read): self
    {
        $self = clone $this;
        $self['read'] = $read;

        return $self;
    }

    public function withTo(int $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }
}
