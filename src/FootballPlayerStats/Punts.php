<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlayerStats;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PuntsShape = array{
 *   attempts: int|null,
 *   avgNetYards: float|null,
 *   avgYards: float|null,
 *   inside20: int|null,
 *   longest: int|null,
 *   yards: int|null,
 * }
 */
final class Punts implements BaseModel
{
    /** @use SdkModel<PuntsShape> */
    use SdkModel;

    /**
     * Punts.
     */
    #[Required]
    public ?int $attempts;

    /**
     * Net yards per punt, after returns.
     */
    #[Required]
    public ?float $avgNetYards;

    /**
     * Yards per punt.
     */
    #[Required]
    public ?float $avgYards;

    /**
     * Punts downed inside the 20.
     */
    #[Required]
    public ?int $inside20;

    /**
     * The longest punt, in yards.
     */
    #[Required]
    public ?int $longest;

    /**
     * Punting yards.
     */
    #[Required]
    public ?int $yards;

    /**
     * `new Punts()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Punts::with(attempts: ..., avgNetYards: ..., avgYards: ..., inside20: ..., longest: ..., yards: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Punts)->withAttempts(...)->withAvgNetYards(...)->withAvgYards(...)->withInside20(...)->withLongest(...)->withYards(...)
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
    public static function with(?int $attempts, ?float $avgNetYards, ?float $avgYards, ?int $inside20, ?int $longest, ?int $yards): self
    {
        $self = new self;

        $self['attempts'] = $attempts;
        $self['avgNetYards'] = $avgNetYards;
        $self['avgYards'] = $avgYards;
        $self['inside20'] = $inside20;
        $self['longest'] = $longest;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * Punts.
     */
    public function withAttempts(?int $attempts): self
    {
        $self = clone $this;
        $self['attempts'] = $attempts;

        return $self;
    }

    /**
     * Net yards per punt, after returns.
     */
    public function withAvgNetYards(?float $avgNetYards): self
    {
        $self = clone $this;
        $self['avgNetYards'] = $avgNetYards;

        return $self;
    }

    /**
     * Yards per punt.
     */
    public function withAvgYards(?float $avgYards): self
    {
        $self = clone $this;
        $self['avgYards'] = $avgYards;

        return $self;
    }

    /**
     * Punts downed inside the 20.
     */
    public function withInside20(?int $inside20): self
    {
        $self = clone $this;
        $self['inside20'] = $inside20;

        return $self;
    }

    /**
     * The longest punt, in yards.
     */
    public function withLongest(?int $longest): self
    {
        $self = clone $this;
        $self['longest'] = $longest;

        return $self;
    }

    /**
     * Punting yards.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }
}
