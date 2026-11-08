<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ActivityRecord;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ChargeShape = array{
 *   credits: int,
 *   balanceAfter: int,
 *   at: \DateTimeInterface,
 * }
 */
final class Charge implements BaseModel
{
    /** @use SdkModel<ChargeShape> */
    use SdkModel;

    #[Required]
    public int $credits;

    #[Required]
    public int $balanceAfter;

    #[Required]
    public \DateTimeInterface $at;

    /**
     * `new Charge()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Charge::with(credits: ..., balanceAfter: ..., at: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Charge)->withCredits(...)->withBalanceAfter(...)->withAt(...)
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
    public static function with(int $credits, int $balanceAfter, \DateTimeInterface $at): self
    {
        $self = new self;

        $self['credits'] = $credits;
        $self['balanceAfter'] = $balanceAfter;
        $self['at'] = $at;

        return $self;
    }

    public function withCredits(int $credits): self
    {
        $self = clone $this;
        $self['credits'] = $credits;

        return $self;
    }

    public function withBalanceAfter(int $balanceAfter): self
    {
        $self = clone $this;
        $self['balanceAfter'] = $balanceAfter;

        return $self;
    }

    public function withAt(\DateTimeInterface $at): self
    {
        $self = clone $this;
        $self['at'] = $at;

        return $self;
    }
}
