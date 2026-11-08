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
 * @phpstan-type CoverageShape = array{
 *   percent: float,
 *   read: int,
 *   total: int,
 * }
 */
final class Coverage implements BaseModel
{
    /** @use SdkModel<CoverageShape> */
    use SdkModel;

    #[Required]
    public float $percent;

    #[Required]
    public int $read;

    #[Required]
    public int $total;

    /**
     * `new Coverage()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Coverage::with(percent: ..., read: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Coverage)->withPercent(...)->withRead(...)->withTotal(...)
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
    public static function with(float $percent, int $read, int $total): self
    {
        $self = new self;

        $self['percent'] = $percent;
        $self['read'] = $read;
        $self['total'] = $total;

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

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
