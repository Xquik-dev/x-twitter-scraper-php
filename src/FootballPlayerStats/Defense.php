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
 * @phpstan-type DefenseShape = array{
 *   combined: float|null,
 *   forcedFumbles: int|null,
 *   interceptions: int|null,
 *   passesDefended: int|null,
 *   sacks: float|null,
 *   tackles: float|null,
 *   tacklesForLoss: float|null,
 * }
 */
final class Defense implements BaseModel
{
    /** @use SdkModel<DefenseShape> */
    use SdkModel;

    /**
     * Solo & assisted tackles together.
     */
    #[Required]
    public ?float $combined;

    /**
     * Fumbles forced.
     */
    #[Required]
    public ?int $forcedFumbles;

    /**
     * Interceptions.
     */
    #[Required]
    public ?int $interceptions;

    /**
     * Passes defended.
     */
    #[Required]
    public ?int $passesDefended;

    /**
     * Sacks, with a shared sack as 0.5.
     */
    #[Required]
    public ?float $sacks;

    /**
     * Solo tackles.
     */
    #[Required]
    public ?float $tackles;

    /**
     * Tackles for a loss.
     */
    #[Required]
    public ?float $tacklesForLoss;

    /**
     * `new Defense()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Defense::with(combined: ..., forcedFumbles: ..., interceptions: ..., passesDefended: ..., sacks: ..., tackles: ..., tacklesForLoss: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Defense)->withCombined(...)->withForcedFumbles(...)->withInterceptions(...)->withPassesDefended(...)->withSacks(...)->withTackles(...)->withTacklesForLoss(...)
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
    public static function with(?float $combined, ?int $forcedFumbles, ?int $interceptions, ?int $passesDefended, ?float $sacks, ?float $tackles, ?float $tacklesForLoss): self
    {
        $self = new self;

        $self['combined'] = $combined;
        $self['forcedFumbles'] = $forcedFumbles;
        $self['interceptions'] = $interceptions;
        $self['passesDefended'] = $passesDefended;
        $self['sacks'] = $sacks;
        $self['tackles'] = $tackles;
        $self['tacklesForLoss'] = $tacklesForLoss;

        return $self;
    }

    /**
     * Solo & assisted tackles together.
     */
    public function withCombined(?float $combined): self
    {
        $self = clone $this;
        $self['combined'] = $combined;

        return $self;
    }

    /**
     * Fumbles forced.
     */
    public function withForcedFumbles(?int $forcedFumbles): self
    {
        $self = clone $this;
        $self['forcedFumbles'] = $forcedFumbles;

        return $self;
    }

    /**
     * Interceptions.
     */
    public function withInterceptions(?int $interceptions): self
    {
        $self = clone $this;
        $self['interceptions'] = $interceptions;

        return $self;
    }

    /**
     * Passes defended.
     */
    public function withPassesDefended(?int $passesDefended): self
    {
        $self = clone $this;
        $self['passesDefended'] = $passesDefended;

        return $self;
    }

    /**
     * Sacks, with a shared sack as 0.5.
     */
    public function withSacks(?float $sacks): self
    {
        $self = clone $this;
        $self['sacks'] = $sacks;

        return $self;
    }

    /**
     * Solo tackles.
     */
    public function withTackles(?float $tackles): self
    {
        $self = clone $this;
        $self['tackles'] = $tackles;

        return $self;
    }

    /**
     * Tackles for a loss.
     */
    public function withTacklesForLoss(?float $tacklesForLoss): self
    {
        $self = clone $this;
        $self['tacklesForLoss'] = $tacklesForLoss;

        return $self;
    }
}
