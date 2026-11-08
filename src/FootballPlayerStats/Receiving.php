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
 * @phpstan-type ReceivingShape = array{
 *   avgYards: float|null,
 *   longest: int|null,
 *   receptions: int|null,
 *   targets: int|null,
 *   touchdowns: int|null,
 *   yards: int|null,
 * }
 */
final class Receiving implements BaseModel
{
    /** @use SdkModel<ReceivingShape> */
    use SdkModel;

    /**
     * Yards per catch.
     */
    #[Required]
    public ?float $avgYards;

    /**
     * The longest catch, in yards.
     */
    #[Required]
    public ?int $longest;

    /**
     * Catches.
     */
    #[Required]
    public ?int $receptions;

    /**
     * Passes thrown to the player.
     */
    #[Required]
    public ?int $targets;

    /**
     * Receiving touchdowns.
     */
    #[Required]
    public ?int $touchdowns;

    /**
     * Receiving yards.
     */
    #[Required]
    public ?int $yards;

    /**
     * `new Receiving()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Receiving::with(avgYards: ..., longest: ..., receptions: ..., targets: ..., touchdowns: ..., yards: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Receiving)->withAvgYards(...)->withLongest(...)->withReceptions(...)->withTargets(...)->withTouchdowns(...)->withYards(...)
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
    public static function with(?float $avgYards, ?int $longest, ?int $receptions, ?int $targets, ?int $touchdowns, ?int $yards): self
    {
        $self = new self;

        $self['avgYards'] = $avgYards;
        $self['longest'] = $longest;
        $self['receptions'] = $receptions;
        $self['targets'] = $targets;
        $self['touchdowns'] = $touchdowns;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * Yards per catch.
     */
    public function withAvgYards(?float $avgYards): self
    {
        $self = clone $this;
        $self['avgYards'] = $avgYards;

        return $self;
    }

    /**
     * The longest catch, in yards.
     */
    public function withLongest(?int $longest): self
    {
        $self = clone $this;
        $self['longest'] = $longest;

        return $self;
    }

    /**
     * Catches.
     */
    public function withReceptions(?int $receptions): self
    {
        $self = clone $this;
        $self['receptions'] = $receptions;

        return $self;
    }

    /**
     * Passes thrown to the player.
     */
    public function withTargets(?int $targets): self
    {
        $self = clone $this;
        $self['targets'] = $targets;

        return $self;
    }

    /**
     * Receiving touchdowns.
     */
    public function withTouchdowns(?int $touchdowns): self
    {
        $self = clone $this;
        $self['touchdowns'] = $touchdowns;

        return $self;
    }

    /**
     * Receiving yards.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }
}
