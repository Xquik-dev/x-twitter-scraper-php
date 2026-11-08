<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballRoster\League;

/**
 * @phpstan-type FootballRosterShape = array{
 *   id: string,
 *   league: League|value-of<League>,
 *   rosters: list<FootballRosterTeam|array<string,mixed>>,
 *   teams: array<string,mixed>,
 *   players: array<string,mixed>,
 * }
 */
final class FootballRoster implements BaseModel
{
    /** @use SdkModel<FootballRosterShape> */
    use SdkModel;

    /**
     * The ID of the game these rosters cover.
     */
    #[Required]
    public string $id;

    /**
     * The league of the game these rosters cover.
     *
     * @var value-of<League> $league
     */
    #[Required(enum: League::class)]
    public string $league;

    /**
     * Each team's roster, in X's order.
     *
     * @var list<FootballRosterTeam> $rosters
     */
    #[Required(list: FootballRosterTeam::class)]
    public array $rosters;

    /**
     * The 2 teams, by team ID.
     *
     * @var array<string,mixed> $teams
     */
    #[Required(map: 'mixed')]
    public array $teams;

    /**
     * Every rostered player, by player ID. Rosters carry no college or birth details & only a medium headshot, so the rest are null.
     *
     * @var array<string,mixed> $players
     */
    #[Required(map: 'mixed')]
    public array $players;

    /**
     * `new FootballRoster()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballRoster::with(id: ..., league: ..., rosters: ..., teams: ..., players: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballRoster)->withId(...)->withLeague(...)->withRosters(...)->withTeams(...)->withPlayers(...)
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
     * @param list<FootballRosterTeam|array<string,mixed>> $rosters
     * @param array<string,mixed> $teams
     * @param array<string,mixed> $players
     */
    public static function with(string $id, League|string $league, array $rosters, array $teams, array $players): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['league'] = $league;
        $self['rosters'] = $rosters;
        $self['teams'] = $teams;
        $self['players'] = $players;

        return $self;
    }

    /**
     * The ID of the game these rosters cover.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The league of the game these rosters cover.
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
     * Each team's roster, in X's order.
     *
     * @param list<FootballRosterTeam|array<string,mixed>> $rosters
     */
    public function withRosters(array $rosters): self
    {
        $self = clone $this;
        $self['rosters'] = $rosters;

        return $self;
    }

    /**
     * The 2 teams, by team ID.
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
     * Every rostered player, by player ID. Rosters carry no college or birth details & only a medium headshot, so the rest are null.
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
