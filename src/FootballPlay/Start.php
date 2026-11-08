<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlay;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type StartShape = array{
 *   down: int|null,
 *   yardsToGo: int|null,
 *   yardline: int|null,
 *   yardlineSide: string|null,
 *   possession: string|null,
 * }
 */
final class Start implements BaseModel
{
    /** @use SdkModel<StartShape> */
    use SdkModel;

    /**
     * The down, from 1 to 4.
     */
    #[Required]
    public ?int $down;

    /**
     * The yards needed for a first down.
     */
    #[Required]
    public ?int $yardsToGo;

    /**
     * The yard line of the ball.
     */
    #[Required]
    public ?int $yardline;

    /**
     * Whose half the ball was in. Home or Away in NFL games, the team's alternateId in college games.
     */
    #[Required]
    public ?string $yardlineSide;

    /**
     * The team with the ball. Home or Away in NFL games, the team's alternateId in college games.
     */
    #[Required]
    public ?string $possession;

    /**
     * `new Start()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Start::with(down: ..., yardsToGo: ..., yardline: ..., yardlineSide: ..., possession: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Start)->withDown(...)->withYardsToGo(...)->withYardline(...)->withYardlineSide(...)->withPossession(...)
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
    public static function with(?int $down, ?int $yardsToGo, ?int $yardline, ?string $yardlineSide, ?string $possession): self
    {
        $self = new self;

        $self['down'] = $down;
        $self['yardsToGo'] = $yardsToGo;
        $self['yardline'] = $yardline;
        $self['yardlineSide'] = $yardlineSide;
        $self['possession'] = $possession;

        return $self;
    }

    /**
     * The down, from 1 to 4.
     */
    public function withDown(?int $down): self
    {
        $self = clone $this;
        $self['down'] = $down;

        return $self;
    }

    /**
     * The yards needed for a first down.
     */
    public function withYardsToGo(?int $yardsToGo): self
    {
        $self = clone $this;
        $self['yardsToGo'] = $yardsToGo;

        return $self;
    }

    /**
     * The yard line of the ball.
     */
    public function withYardline(?int $yardline): self
    {
        $self = clone $this;
        $self['yardline'] = $yardline;

        return $self;
    }

    /**
     * Whose half the ball was in. Home or Away in NFL games, the team's alternateId in college games.
     */
    public function withYardlineSide(?string $yardlineSide): self
    {
        $self = clone $this;
        $self['yardlineSide'] = $yardlineSide;

        return $self;
    }

    /**
     * The team with the ball. Home or Away in NFL games, the team's alternateId in college games.
     */
    public function withPossession(?string $possession): self
    {
        $self = clone $this;
        $self['possession'] = $possession;

        return $self;
    }
}
