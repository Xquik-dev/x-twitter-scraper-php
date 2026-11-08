<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballBoxScore\League;

/**
 * @phpstan-type FootballBoxScoreShape = array{
 *   id: string,
 *   league: League|value-of<League>,
 *   home: FootballTeamBox|array<string,mixed>,
 *   away: FootballTeamBox|array<string,mixed>,
 *   teams: array<string,mixed>,
 *   players: array<string,mixed>,
 * }
 */
final class FootballBoxScore implements BaseModel
{
    /** @use SdkModel<FootballBoxScoreShape> */
    use SdkModel;

    /**
     * The ID of the game this box score covers.
     */
    #[Required]
    public string $id;

    /**
     * The league of the game this box score covers.
     *
     * @var value-of<League> $league
     */
    #[Required(enum: League::class)]
    public string $league;

    /**
     * 1 team's totals & player stats.
     */
    #[Required]
    public FootballTeamBox $home;

    /**
     * 1 team's totals & player stats.
     */
    #[Required]
    public FootballTeamBox $away;

    /**
     * The teams this box score names, by team ID.
     *
     * @var array<string,mixed> $teams
     */
    #[Required(map: 'mixed')]
    public array $teams;

    /**
     * The players this box score names, by player ID.
     *
     * @var array<string,mixed> $players
     */
    #[Required(map: 'mixed')]
    public array $players;

    /**
     * `new FootballBoxScore()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballBoxScore::with(id: ..., league: ..., home: ..., away: ..., teams: ..., players: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballBoxScore)->withId(...)->withLeague(...)->withHome(...)->withAway(...)->withTeams(...)->withPlayers(...)
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
     * @param League|value-of<League> $league
     * @param FootballTeamBox|array<string,mixed> $home
     * @param FootballTeamBox|array<string,mixed> $away
     * @param array<string,mixed> $teams
     * @param array<string,mixed> $players
     */
    public static function with(string $id, League|string $league, FootballTeamBox|array $home, FootballTeamBox|array $away, array $teams, array $players): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['league'] = $league;
        $self['home'] = $home;
        $self['away'] = $away;
        $self['teams'] = $teams;
        $self['players'] = $players;

        return $self;
    }

    /**
     * The ID of the game this box score covers.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The league of the game this box score covers.
     *
     * @param League|value-of<League> $league
     */
    public function withLeague(League|string $league): self
    {
        $self = clone $this;
        $self['league'] = $league;

        return $self;
    }

    /**
     * 1 team's totals & player stats.
     *
     * @param FootballTeamBox|array<string,mixed> $home
     */
    public function withHome(FootballTeamBox|array $home): self
    {
        $self = clone $this;
        $self['home'] = $home;

        return $self;
    }

    /**
     * 1 team's totals & player stats.
     *
     * @param FootballTeamBox|array<string,mixed> $away
     */
    public function withAway(FootballTeamBox|array $away): self
    {
        $self = clone $this;
        $self['away'] = $away;

        return $self;
    }

    /**
     * The teams this box score names, by team ID.
     *
     * @param array<string,mixed> $teams
     */
    public function withTeams(array $teams): self
    {
        $self = clone $this;
        $self['teams'] = $teams;

        return $self;
    }

    /**
     * The players this box score names, by player ID.
     *
     * @param array<string,mixed> $players
     */
    public function withPlayers(array $players): self
    {
        $self = clone $this;
        $self['players'] = $players;

        return $self;
    }
}
