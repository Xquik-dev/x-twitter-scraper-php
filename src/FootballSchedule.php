<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballSchedule\League;

/**
 * @phpstan-type FootballScheduleShape = array{
 *   league: League|value-of<League>,
 *   games: list<FootballScheduleGame|array<string,mixed>>,
 *   teams: array<string,mixed>,
 * }
 */
final class FootballSchedule implements BaseModel
{
    /** @use SdkModel<FootballScheduleShape> */
    use SdkModel;

    /**
     * The league whose games this list holds.
     *
     * @var value-of<League> $league
     */
    #[Required(enum: League::class)]
    public string $league;

    /**
     * The games, earliest first.
     *
     * @var list<FootballScheduleGame> $games
     */
    #[Required(list: FootballScheduleGame::class)]
    public array $games;

    /**
     * The teams the games name, by team ID.
     *
     * @var array<string,mixed> $teams
     */
    #[Required(map: 'mixed')]
    public array $teams;

    /**
     * `new FootballSchedule()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballSchedule::with(league: ..., games: ..., teams: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballSchedule)->withLeague(...)->withGames(...)->withTeams(...)
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
     * @param list<FootballScheduleGame|array<string,mixed>> $games
     * @param array<string,mixed> $teams
     */
    public static function with(League|string $league, array $games, array $teams): self
    {
        $self = new self;

        $self['league'] = $league;
        $self['games'] = $games;
        $self['teams'] = $teams;

        return $self;
    }

    /**
     * The league whose games this list holds.
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
     * The games, earliest first.
     *
     * @param list<FootballScheduleGame|array<string,mixed>> $games
     */
    public function withGames(array $games): self
    {
        $self = clone $this;
        $self['games'] = $games;

        return $self;
    }

    /**
     * The teams the games name, by team ID.
     *
     * @param array<string,mixed> $teams
     */
    public function withTeams(array $teams): self
    {
        $self = clone $this;
        $self['teams'] = $teams;

        return $self;
    }
}
