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
 * @phpstan-type VerifiedShape = array{
 *   count: int,
 *   percent: float,
 * }
 */
final class Verified implements BaseModel
{
    /** @use SdkModel<VerifiedShape> */
    use SdkModel;

    #[Required]
    public int $count;

    #[Required]
    public float $percent;

    /**
     * `new Verified()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Verified::with(count: ..., percent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Verified)->withCount(...)->withPercent(...)
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
    public static function with(int $count, float $percent): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['percent'] = $percent;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    public function withPercent(float $percent): self
    {
        $self = clone $this;
        $self['percent'] = $percent;

        return $self;
    }
}
