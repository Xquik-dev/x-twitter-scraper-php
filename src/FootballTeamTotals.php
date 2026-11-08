<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballTeamTotals\Penalties;
use XTwitterScraper\FootballTeamTotals\ThirdDowns;

/**
 * @phpstan-type FootballTeamTotalsShape = array{
 *   firstDowns: int|null,
 *   thirdDowns: ThirdDowns|array<string,mixed>|null,
 *   fumbles: FootballFumbleStats|array<string,mixed>|null,
 *   passing: FootballPassingStats|array<string,mixed>|null,
 *   penalties: Penalties|array<string,mixed>|null,
 *   rushing: FootballRushingStats|array<string,mixed>|null,
 *   timeOfPossessionSeconds: int|null,
 *   totalYards: int|null,
 *   turnovers: int|null,
 * }
 */
final class FootballTeamTotals implements BaseModel
{
    /** @use SdkModel<FootballTeamTotalsShape> */
    use SdkModel;

    /**
     * First downs.
     */
    #[Required]
    public ?int $firstDowns;

    /**
     * Third downs tried & converted.
     */
    #[Required]
    public ?ThirdDowns $thirdDowns;

    /**
     * The team's fumbles, or null.
     */
    #[Required]
    public ?FootballFumbleStats $fumbles;

    /**
     * The team's passing, or null.
     */
    #[Required]
    public ?FootballPassingStats $passing;

    /**
     * Penalties against the team.
     */
    #[Required]
    public ?Penalties $penalties;

    /**
     * The team's rushing, or null.
     */
    #[Required]
    public ?FootballRushingStats $rushing;

    /**
     * Time with the ball, in seconds.
     */
    #[Required]
    public ?int $timeOfPossessionSeconds;

    /**
     * Total yards.
     */
    #[Required]
    public ?int $totalYards;

    /**
     * Turnovers.
     */
    #[Required]
    public ?int $turnovers;

    /**
     * `new FootballTeamTotals()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballTeamTotals::with(firstDowns: ..., thirdDowns: ..., fumbles: ..., passing: ..., penalties: ..., rushing: ..., timeOfPossessionSeconds: ..., totalYards: ..., turnovers: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballTeamTotals)->withFirstDowns(...)->withThirdDowns(...)->withFumbles(...)->withPassing(...)->withPenalties(...)->withRushing(...)->withTimeOfPossessionSeconds(...)->withTotalYards(...)->withTurnovers(...)
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
     *
     * @param ThirdDowns|array<string,mixed>|null $thirdDowns
     * @param FootballFumbleStats|array<string,mixed>|null $fumbles
     * @param FootballPassingStats|array<string,mixed>|null $passing
     * @param Penalties|array<string,mixed>|null $penalties
     * @param FootballRushingStats|array<string,mixed>|null $rushing
     */
    public static function with(?int $firstDowns, ThirdDowns|array|null $thirdDowns, FootballFumbleStats|array|null $fumbles, FootballPassingStats|array|null $passing, Penalties|array|null $penalties, FootballRushingStats|array|null $rushing, ?int $timeOfPossessionSeconds, ?int $totalYards, ?int $turnovers): self
    {
        $self = new self;

        $self['firstDowns'] = $firstDowns;
        $self['thirdDowns'] = $thirdDowns;
        $self['fumbles'] = $fumbles;
        $self['passing'] = $passing;
        $self['penalties'] = $penalties;
        $self['rushing'] = $rushing;
        $self['timeOfPossessionSeconds'] = $timeOfPossessionSeconds;
        $self['totalYards'] = $totalYards;
        $self['turnovers'] = $turnovers;

        return $self;
    }

    /**
     * First downs.
     */
    public function withFirstDowns(?int $firstDowns): self
    {
        $self = clone $this;
        $self['firstDowns'] = $firstDowns;

        return $self;
    }

    /**
     * Third downs tried & converted.
     *
     * @param ThirdDowns|array<string,mixed>|null $thirdDowns
     */
    public function withThirdDowns(ThirdDowns|array|null $thirdDowns): self
    {
        $self = clone $this;
        $self['thirdDowns'] = $thirdDowns;

        return $self;
    }

    /**
     * The team's fumbles, or null.
     *
     * @param FootballFumbleStats|array<string,mixed>|null $fumbles
     */
    public function withFumbles(FootballFumbleStats|array|null $fumbles): self
    {
        $self = clone $this;
        $self['fumbles'] = $fumbles;

        return $self;
    }

    /**
     * The team's passing, or null.
     *
     * @param FootballPassingStats|array<string,mixed>|null $passing
     */
    public function withPassing(FootballPassingStats|array|null $passing): self
    {
        $self = clone $this;
        $self['passing'] = $passing;

        return $self;
    }

    /**
     * Penalties against the team.
     *
     * @param Penalties|array<string,mixed>|null $penalties
     */
    public function withPenalties(Penalties|array|null $penalties): self
    {
        $self = clone $this;
        $self['penalties'] = $penalties;

        return $self;
    }

    /**
     * The team's rushing, or null.
     *
     * @param FootballRushingStats|array<string,mixed>|null $rushing
     */
    public function withRushing(FootballRushingStats|array|null $rushing): self
    {
        $self = clone $this;
        $self['rushing'] = $rushing;

        return $self;
    }

    /**
     * Time with the ball, in seconds.
     */
    public function withTimeOfPossessionSeconds(?int $timeOfPossessionSeconds): self
    {
        $self = clone $this;
        $self['timeOfPossessionSeconds'] = $timeOfPossessionSeconds;

        return $self;
    }

    /**
     * Total yards.
     */
    public function withTotalYards(?int $totalYards): self
    {
        $self = clone $this;
        $self['totalYards'] = $totalYards;

        return $self;
    }

    /**
     * Turnovers.
     */
    public function withTurnovers(?int $turnovers): self
    {
        $self = clone $this;
        $self['turnovers'] = $turnovers;

        return $self;
    }
}
