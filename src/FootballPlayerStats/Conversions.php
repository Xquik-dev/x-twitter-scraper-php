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
 * @phpstan-type ConversionsShape = array{
 *   defenseSuccesses: int|null,
 *   passSuccesses: int|null,
 *   rushSuccesses: int|null,
 *   turnoverSuccesses: int|null,
 * }
 */
final class Conversions implements BaseModel
{
    /** @use SdkModel<ConversionsShape> */
    use SdkModel;

    /**
     * Defensive 2-point returns.
     */
    #[Required]
    public ?int $defenseSuccesses;

    /**
     * 2-point conversions by pass.
     */
    #[Required]
    public ?int $passSuccesses;

    /**
     * 2-point conversions by rush.
     */
    #[Required]
    public ?int $rushSuccesses;

    /**
     * 2-point conversions after a turnover.
     */
    #[Required]
    public ?int $turnoverSuccesses;

    /**
     * `new Conversions()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Conversions::with(defenseSuccesses: ..., passSuccesses: ..., rushSuccesses: ..., turnoverSuccesses: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Conversions)->withDefenseSuccesses(...)->withPassSuccesses(...)->withRushSuccesses(...)->withTurnoverSuccesses(...)
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
    public static function with(?int $defenseSuccesses, ?int $passSuccesses, ?int $rushSuccesses, ?int $turnoverSuccesses): self
    {
        $self = new self;

        $self['defenseSuccesses'] = $defenseSuccesses;
        $self['passSuccesses'] = $passSuccesses;
        $self['rushSuccesses'] = $rushSuccesses;
        $self['turnoverSuccesses'] = $turnoverSuccesses;

        return $self;
    }

    /**
     * Defensive 2-point returns.
     */
    public function withDefenseSuccesses(?int $defenseSuccesses): self
    {
        $self = clone $this;
        $self['defenseSuccesses'] = $defenseSuccesses;

        return $self;
    }

    /**
     * 2-point conversions by pass.
     */
    public function withPassSuccesses(?int $passSuccesses): self
    {
        $self = clone $this;
        $self['passSuccesses'] = $passSuccesses;

        return $self;
    }

    /**
     * 2-point conversions by rush.
     */
    public function withRushSuccesses(?int $rushSuccesses): self
    {
        $self = clone $this;
        $self['rushSuccesses'] = $rushSuccesses;

        return $self;
    }

    /**
     * 2-point conversions after a turnover.
     */
    public function withTurnoverSuccesses(?int $turnoverSuccesses): self
    {
        $self = clone $this;
        $self['turnoverSuccesses'] = $turnoverSuccesses;

        return $self;
    }
}
