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
 * @phpstan-type FootballPassingStatsShape = array{
 *   attempts: int|null,
 *   avgYards: float|null,
 *   completions: int|null,
 *   interceptions: int|null,
 *   netYards: int|null,
 *   rating: float|null,
 *   sackYards: int|null,
 *   sacks: int|null,
 *   touchdowns: int|null,
 *   yards: int|null,
 * }
 */
final class FootballPassingStats implements BaseModel
{
    /** @use SdkModel<FootballPassingStatsShape> */
    use SdkModel;

    /**
     * Passes thrown.
     */
    #[Required]
    public ?int $attempts;

    /**
     * Yards per pass.
     */
    #[Required]
    public ?float $avgYards;

    /**
     * Passes caught.
     */
    #[Required]
    public ?int $completions;

    /**
     * Passes intercepted.
     */
    #[Required]
    public ?int $interceptions;

    /**
     * Passing yards minus sack yards.
     */
    #[Required]
    public ?int $netYards;

    /**
     * The passer rating.
     */
    #[Required]
    public ?float $rating;

    /**
     * Yards lost to sacks.
     */
    #[Required]
    public ?int $sackYards;

    /**
     * Times sacked.
     */
    #[Required]
    public ?int $sacks;

    /**
     * Passing touchdowns.
     */
    #[Required]
    public ?int $touchdowns;

    /**
     * Passing yards.
     */
    #[Required]
    public ?int $yards;

    /**
     * `new FootballPassingStats()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPassingStats::with(attempts: ..., avgYards: ..., completions: ..., interceptions: ..., netYards: ..., rating: ..., sackYards: ..., sacks: ..., touchdowns: ..., yards: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPassingStats)->withAttempts(...)->withAvgYards(...)->withCompletions(...)->withInterceptions(...)->withNetYards(...)->withRating(...)->withSackYards(...)->withSacks(...)->withTouchdowns(...)->withYards(...)
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
    public static function with(?int $attempts, ?float $avgYards, ?int $completions, ?int $interceptions, ?int $netYards, ?float $rating, ?int $sackYards, ?int $sacks, ?int $touchdowns, ?int $yards): self
    {
        $self = new self;

        $self['attempts'] = $attempts;
        $self['avgYards'] = $avgYards;
        $self['completions'] = $completions;
        $self['interceptions'] = $interceptions;
        $self['netYards'] = $netYards;
        $self['rating'] = $rating;
        $self['sackYards'] = $sackYards;
        $self['sacks'] = $sacks;
        $self['touchdowns'] = $touchdowns;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * Passes thrown.
     */
    public function withAttempts(?int $attempts): self
    {
        $self = clone $this;
        $self['attempts'] = $attempts;

        return $self;
    }

    /**
     * Yards per pass.
     */
    public function withAvgYards(?float $avgYards): self
    {
        $self = clone $this;
        $self['avgYards'] = $avgYards;

        return $self;
    }

    /**
     * Passes caught.
     */
    public function withCompletions(?int $completions): self
    {
        $self = clone $this;
        $self['completions'] = $completions;

        return $self;
    }

    /**
     * Passes intercepted.
     */
    public function withInterceptions(?int $interceptions): self
    {
        $self = clone $this;
        $self['interceptions'] = $interceptions;

        return $self;
    }

    /**
     * Passing yards minus sack yards.
     */
    public function withNetYards(?int $netYards): self
    {
        $self = clone $this;
        $self['netYards'] = $netYards;

        return $self;
    }

    /**
     * The passer rating.
     */
    public function withRating(?float $rating): self
    {
        $self = clone $this;
        $self['rating'] = $rating;

        return $self;
    }

    /**
     * Yards lost to sacks.
     */
    public function withSackYards(?int $sackYards): self
    {
        $self = clone $this;
        $self['sackYards'] = $sackYards;

        return $self;
    }

    /**
     * Times sacked.
     */
    public function withSacks(?int $sacks): self
    {
        $self = clone $this;
        $self['sacks'] = $sacks;

        return $self;
    }

    /**
     * Passing touchdowns.
     */
    public function withTouchdowns(?int $touchdowns): self
    {
        $self = clone $this;
        $self['touchdowns'] = $touchdowns;

        return $self;
    }

    /**
     * Passing yards.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }
}
