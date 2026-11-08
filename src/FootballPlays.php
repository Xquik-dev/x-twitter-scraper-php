<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballPlays\League;

/**
 * @phpstan-type FootballPlaysShape = array{
 *   id: string,
 *   league: League|value-of<League>,
 *   homeTeamID: string|null,
 *   awayTeamID: string|null,
 *   quarters: list<FootballQuarter|array<string,mixed>>,
 *   teams: array<string,mixed>,
 *   players: array<string,mixed>,
 * }
 */
final class FootballPlays implements BaseModel
{
    /** @use SdkModel<FootballPlaysShape> */
    use SdkModel;

    /**
     * The ID of the game these plays come from.
     */
    #[Required]
    public string $id;

    /**
     * The league of the game these plays come from.
     *
     * @var value-of<League> $league
     */
    #[Required(enum: League::class)]
    public string $league;

    /**
     * The home team, a key of teams.
     */
    #[Required('homeTeamId')]
    public ?string $homeTeamID;

    /**
     * The away team, a key of teams.
     */
    #[Required('awayTeamId')]
    public ?string $awayTeamID;

    /**
     * The game's quarters, in order. Empty before kickoff.
     *
     * @var list<FootballQuarter> $quarters
     */
    #[Required(list: FootballQuarter::class)]
    public array $quarters;

    /**
     * The teams these plays name, by team ID.
     *
     * @var array<string,mixed> $teams
     */
    #[Required(map: 'mixed')]
    public array $teams;

    /**
     * The players these plays name, by player ID.
     *
     * @var array<string,mixed> $players
     */
    #[Required(map: 'mixed')]
    public array $players;

    /**
     * `new FootballPlays()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPlays::with(id: ..., league: ..., homeTeamID: ..., awayTeamID: ..., quarters: ..., teams: ..., players: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPlays)->withId(...)->withLeague(...)->withHomeTeamID(...)->withAwayTeamID(...)->withQuarters(...)->withTeams(...)->withPlayers(...)
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
     * @param list<FootballQuarter|array<string,mixed>> $quarters
     * @param array<string,mixed> $teams
     * @param array<string,mixed> $players
     */
    public static function with(string $id, League|string $league, ?string $homeTeamID, ?string $awayTeamID, array $quarters, array $teams, array $players): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['league'] = $league;
        $self['homeTeamID'] = $homeTeamID;
        $self['awayTeamID'] = $awayTeamID;
        $self['quarters'] = $quarters;
        $self['teams'] = $teams;
        $self['players'] = $players;

        return $self;
    }

    /**
     * The ID of the game these plays come from.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The league of the game these plays come from.
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
     * The home team, a key of teams.
     */
    public function withHomeTeamID(?string $homeTeamID): self
    {
        $self = clone $this;
        $self['homeTeamID'] = $homeTeamID;

        return $self;
    }

    /**
     * The away team, a key of teams.
     */
    public function withAwayTeamID(?string $awayTeamID): self
    {
        $self = clone $this;
        $self['awayTeamID'] = $awayTeamID;

        return $self;
    }

    /**
     * The game's quarters, in order. Empty before kickoff.
     *
     * @param list<FootballQuarter|array<string,mixed>> $quarters
     */
    public function withQuarters(array $quarters): self
    {
        $self = clone $this;
        $self['quarters'] = $quarters;

        return $self;
    }

    /**
     * The teams these plays name, by team ID.
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
     * The players these plays name, by player ID.
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
