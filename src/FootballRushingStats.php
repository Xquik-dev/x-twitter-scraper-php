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
 * @phpstan-type FootballRushingStatsShape = array{
 *   attempts: int|null,
 *   avgYards: float|null,
 *   longest: int|null,
 *   touchdowns: int|null,
 *   yards: int|null,
 * }
 */
final class FootballRushingStats implements BaseModel
{
    /** @use SdkModel<FootballRushingStatsShape> */
    use SdkModel;

    /**
     * Rushes.
     */
    #[Required]
    public ?int $attempts;

    /**
     * Yards per rush.
     */
    #[Required]
    public ?float $avgYards;

    /**
     * The longest rush, in yards.
     */
    #[Required]
    public ?int $longest;

    /**
     * Rushing touchdowns.
     */
    #[Required]
    public ?int $touchdowns;

    /**
     * Rushing yards.
     */
    #[Required]
    public ?int $yards;

    /**
     * `new FootballRushingStats()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballRushingStats::with(attempts: ..., avgYards: ..., longest: ..., touchdowns: ..., yards: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballRushingStats)->withAttempts(...)->withAvgYards(...)->withLongest(...)->withTouchdowns(...)->withYards(...)
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
    public static function with(?int $attempts, ?float $avgYards, ?int $longest, ?int $touchdowns, ?int $yards): self
    {
        $self = new self;

        $self['attempts'] = $attempts;
        $self['avgYards'] = $avgYards;
        $self['longest'] = $longest;
        $self['touchdowns'] = $touchdowns;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * Rushes.
     */
    public function withAttempts(?int $attempts): self
    {
        $self = clone $this;
        $self['attempts'] = $attempts;

        return $self;
    }

    /**
     * Yards per rush.
     */
    public function withAvgYards(?float $avgYards): self
    {
        $self = clone $this;
        $self['avgYards'] = $avgYards;

        return $self;
    }

    /**
     * The longest rush, in yards.
     */
    public function withLongest(?int $longest): self
    {
        $self = clone $this;
        $self['longest'] = $longest;

        return $self;
    }

    /**
     * Rushing touchdowns.
     */
    public function withTouchdowns(?int $touchdowns): self
    {
        $self = clone $this;
        $self['touchdowns'] = $touchdowns;

        return $self;
    }

    /**
     * Rushing yards.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }
}
