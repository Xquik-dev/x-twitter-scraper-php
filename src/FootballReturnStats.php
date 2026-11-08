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
 * @phpstan-type FootballReturnStatsShape = array{
 *   avgYards: float|null,
 *   longest: int|null,
 *   returns: int|null,
 *   touchdowns: int|null,
 *   yards: int|null,
 * }
 */
final class FootballReturnStats implements BaseModel
{
    /** @use SdkModel<FootballReturnStatsShape> */
    use SdkModel;

    /**
     * Yards per return.
     */
    #[Required]
    public ?float $avgYards;

    /**
     * The longest return, in yards.
     */
    #[Required]
    public ?int $longest;

    /**
     * Returns.
     */
    #[Required]
    public ?int $returns;

    /**
     * Return touchdowns.
     */
    #[Required]
    public ?int $touchdowns;

    /**
     * Return yards.
     */
    #[Required]
    public ?int $yards;

    /**
     * `new FootballReturnStats()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballReturnStats::with(avgYards: ..., longest: ..., returns: ..., touchdowns: ..., yards: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballReturnStats)->withAvgYards(...)->withLongest(...)->withReturns(...)->withTouchdowns(...)->withYards(...)
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
    public static function with(?float $avgYards, ?int $longest, ?int $returns, ?int $touchdowns, ?int $yards): self
    {
        $self = new self;

        $self['avgYards'] = $avgYards;
        $self['longest'] = $longest;
        $self['returns'] = $returns;
        $self['touchdowns'] = $touchdowns;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * Yards per return.
     */
    public function withAvgYards(?float $avgYards): self
    {
        $self = clone $this;
        $self['avgYards'] = $avgYards;

        return $self;
    }

    /**
     * The longest return, in yards.
     */
    public function withLongest(?int $longest): self
    {
        $self = clone $this;
        $self['longest'] = $longest;

        return $self;
    }

    /**
     * Returns.
     */
    public function withReturns(?int $returns): self
    {
        $self = clone $this;
        $self['returns'] = $returns;

        return $self;
    }

    /**
     * Return touchdowns.
     */
    public function withTouchdowns(?int $touchdowns): self
    {
        $self = clone $this;
        $self['touchdowns'] = $touchdowns;

        return $self;
    }

    /**
     * Return yards.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }
}
