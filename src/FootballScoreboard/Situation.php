<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballScoreboard;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SituationShape = array{
 *   down: int|null,
 *   yardsToGo: int|null,
 *   yardline: int|null,
 *   yardlineTeamID: string|null,
 *   possessionTeamID: string|null,
 * }
 */
final class Situation implements BaseModel
{
    /** @use SdkModel<SituationShape> */
    use SdkModel;

    /**
     * The current down, from 1 to 4.
     */
    #[Required]
    public ?int $down;

    /**
     * The yards the offense needs now for a first down.
     */
    #[Required]
    public ?int $yardsToGo;

    /**
     * The ball's current yard line.
     */
    #[Required]
    public ?int $yardline;

    /**
     * The team whose half the ball is in, a key of teams.
     */
    #[Required('yardlineTeamId')]
    public ?string $yardlineTeamID;

    /**
     * The team with the ball, a key of teams.
     */
    #[Required('possessionTeamId')]
    public ?string $possessionTeamID;

    /**
     * `new Situation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Situation::with(down: ..., yardsToGo: ..., yardline: ..., yardlineTeamID: ..., possessionTeamID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Situation)->withDown(...)->withYardsToGo(...)->withYardline(...)->withYardlineTeamID(...)->withPossessionTeamID(...)
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
    public static function with(?int $down, ?int $yardsToGo, ?int $yardline, ?string $yardlineTeamID, ?string $possessionTeamID): self
    {
        $self = new self;

        $self['down'] = $down;
        $self['yardsToGo'] = $yardsToGo;
        $self['yardline'] = $yardline;
        $self['yardlineTeamID'] = $yardlineTeamID;
        $self['possessionTeamID'] = $possessionTeamID;

        return $self;
    }

    /**
     * The current down, from 1 to 4.
     */
    public function withDown(?int $down): self
    {
        $self = clone $this;
        $self['down'] = $down;

        return $self;
    }

    /**
     * The yards the offense needs now for a first down.
     */
    public function withYardsToGo(?int $yardsToGo): self
    {
        $self = clone $this;
        $self['yardsToGo'] = $yardsToGo;

        return $self;
    }

    /**
     * The ball's current yard line.
     */
    public function withYardline(?int $yardline): self
    {
        $self = clone $this;
        $self['yardline'] = $yardline;

        return $self;
    }

    /**
     * The team whose half the ball is in, a key of teams.
     */
    public function withYardlineTeamID(?string $yardlineTeamID): self
    {
        $self = clone $this;
        $self['yardlineTeamID'] = $yardlineTeamID;

        return $self;
    }

    /**
     * The team with the ball, a key of teams.
     */
    public function withPossessionTeamID(?string $possessionTeamID): self
    {
        $self = clone $this;
        $self['possessionTeamID'] = $possessionTeamID;

        return $self;
    }
}
