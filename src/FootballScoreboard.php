<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballScoreboard\League;
use XTwitterScraper\FootballScoreboard\Situation;

/**
 * @phpstan-type FootballScoreboardShape = array{
 *   id: string,
 *   league: League|value-of<League>,
 *   seasonID: string|null,
 *   seasonType: string|null,
 *   week: int|null,
 *   startsAt: \DateTimeInterface|null,
 *   venue: string|null,
 *   status: string|null,
 *   clock: string|null,
 *   quarter: int|null,
 *   situation: Situation|array<string,mixed>|null,
 *   home: FootballSide|array<string,mixed>,
 *   away: FootballSide|array<string,mixed>,
 *   periods: list<FootballPeriod|array<string,mixed>>,
 *   lastPlay: FootballPlay|array<string,mixed>|null,
 *   teams: array<string,mixed>,
 *   players: array<string,mixed>,
 * }
 */
final class FootballScoreboard implements BaseModel
{
    /** @use SdkModel<FootballScoreboardShape> */
    use SdkModel;

    /**
     * The game ID from your request.
     */
    #[Required]
    public string $id;

    /**
     * The league from your request.
     *
     * @var value-of<League> $league
     */
    #[Required(enum: League::class)]
    public string $league;

    /**
     * X's ID for the season. NFL games have one.
     */
    #[Required('seasonId')]
    public ?string $seasonID;

    /**
     * The part of the season, such as RegularSeason. X stopped sending it with a game on 2026-10-24, so it is null.
     */
    #[Required]
    public ?string $seasonType;

    /**
     * The week of the season. X stopped sending it with a game on 2026-10-24, so it is null. The games list still has each week.
     */
    #[Required]
    public ?int $week;

    /**
     * The kickoff time in UTC, or null when X sends none Xquik can read.
     */
    #[Required]
    public ?\DateTimeInterface $startsAt;

    /**
     * The stadium.
     */
    #[Required]
    public ?string $venue;

    /**
     * X's game status, such as Scheduled, InProgress or Closed.
     */
    #[Required]
    public ?string $status;

    /**
     * The game clock, as X writes it.
     */
    #[Required]
    public ?string $clock;

    /**
     * The current or last quarter.
     */
    #[Required]
    public ?int $quarter;

    /**
     * Down & distance now, or null before kickoff.
     */
    #[Required]
    public ?Situation $situation;

    /**
     * A team's side of a scoreboard.
     */
    #[Required]
    public FootballSide $home;

    /**
     * A team's side of a scoreboard.
     */
    #[Required]
    public FootballSide $away;

    /**
     * Points by period, in order.
     *
     * @var list<FootballPeriod> $periods
     */
    #[Required(list: FootballPeriod::class)]
    public array $periods;

    /**
     * The latest play, or null before kickoff. Its steps can list no players for a short while.
     */
    #[Required]
    public ?FootballPlay $lastPlay;

    /**
     * The teams this answer names, by team ID.
     *
     * @var array<string,mixed> $teams
     */
    #[Required(map: 'mixed')]
    public array $teams;

    /**
     * The players this answer names, by player ID.
     *
     * @var array<string,mixed> $players
     */
    #[Required(map: 'mixed')]
    public array $players;

    /**
     * `new FootballScoreboard()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballScoreboard::with(id: ..., league: ..., seasonID: ..., seasonType: ..., week: ..., startsAt: ..., venue: ..., status: ..., clock: ..., quarter: ..., situation: ..., home: ..., away: ..., periods: ..., lastPlay: ..., teams: ..., players: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballScoreboard)->withId(...)->withLeague(...)->withSeasonID(...)->withSeasonType(...)->withWeek(...)->withStartsAt(...)->withVenue(...)->withStatus(...)->withClock(...)->withQuarter(...)->withSituation(...)->withHome(...)->withAway(...)->withPeriods(...)->withLastPlay(...)->withTeams(...)->withPlayers(...)
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
     * @param Situation|array<string,mixed>|null $situation
     * @param FootballSide|array<string,mixed> $home
     * @param FootballSide|array<string,mixed> $away
     * @param list<FootballPeriod|array<string,mixed>> $periods
     * @param FootballPlay|array<string,mixed>|null $lastPlay
     * @param array<string,mixed> $teams
     * @param array<string,mixed> $players
     */
    public static function with(string $id, League|string $league, ?string $seasonID, ?string $seasonType, ?int $week, ?\DateTimeInterface $startsAt, ?string $venue, ?string $status, ?string $clock, ?int $quarter, Situation|array|null $situation, FootballSide|array $home, FootballSide|array $away, array $periods, FootballPlay|array|null $lastPlay, array $teams, array $players): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['league'] = $league;
        $self['seasonID'] = $seasonID;
        $self['seasonType'] = $seasonType;
        $self['week'] = $week;
        $self['startsAt'] = $startsAt;
        $self['venue'] = $venue;
        $self['status'] = $status;
        $self['clock'] = $clock;
        $self['quarter'] = $quarter;
        $self['situation'] = $situation;
        $self['home'] = $home;
        $self['away'] = $away;
        $self['periods'] = $periods;
        $self['lastPlay'] = $lastPlay;
        $self['teams'] = $teams;
        $self['players'] = $players;

        return $self;
    }

    /**
     * The game ID from your request.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The league from your request.
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
     * X's ID for the season. NFL games have one.
     */
    public function withSeasonID(?string $seasonID): self
    {
        $self = clone $this;
        $self['seasonID'] = $seasonID;

        return $self;
    }

    /**
     * The part of the season, such as RegularSeason. X stopped sending it with a game on 2026-10-24, so it is null.
     */
    public function withSeasonType(?string $seasonType): self
    {
        $self = clone $this;
        $self['seasonType'] = $seasonType;

        return $self;
    }

    /**
     * The week of the season. X stopped sending it with a game on 2026-10-24, so it is null. The games list still has each week.
     */
    public function withWeek(?int $week): self
    {
        $self = clone $this;
        $self['week'] = $week;

        return $self;
    }

    /**
     * The kickoff time in UTC, or null when X sends none Xquik can read.
     */
    public function withStartsAt(?\DateTimeInterface $startsAt): self
    {
        $self = clone $this;
        $self['startsAt'] = $startsAt;

        return $self;
    }

    /**
     * The stadium.
     */
    public function withVenue(?string $venue): self
    {
        $self = clone $this;
        $self['venue'] = $venue;

        return $self;
    }

    /**
     * X's game status, such as Scheduled, InProgress or Closed.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The game clock, as X writes it.
     */
    public function withClock(?string $clock): self
    {
        $self = clone $this;
        $self['clock'] = $clock;

        return $self;
    }

    /**
     * The current or last quarter.
     */
    public function withQuarter(?int $quarter): self
    {
        $self = clone $this;
        $self['quarter'] = $quarter;

        return $self;
    }

    /**
     * Down & distance now, or null before kickoff.
     *
     * @param Situation|array<string,mixed>|null $situation
     */
    public function withSituation(Situation|array|null $situation): self
    {
        $self = clone $this;
        $self['situation'] = $situation;

        return $self;
    }

    /**
     * A team's side of a scoreboard.
     *
     * @param FootballSide|array<string,mixed> $home
     */
    public function withHome(FootballSide|array $home): self
    {
        $self = clone $this;
        $self['home'] = $home;

        return $self;
    }

    /**
     * A team's side of a scoreboard.
     *
     * @param FootballSide|array<string,mixed> $away
     */
    public function withAway(FootballSide|array $away): self
    {
        $self = clone $this;
        $self['away'] = $away;

        return $self;
    }

    /**
     * Points by period, in order.
     *
     * @param list<FootballPeriod|array<string,mixed>> $periods
     */
    public function withPeriods(array $periods): self
    {
        $self = clone $this;
        $self['periods'] = $periods;

        return $self;
    }

    /**
     * The latest play, or null before kickoff. Its steps can list no players for a short while.
     *
     * @param FootballPlay|array<string,mixed>|null $lastPlay
     */
    public function withLastPlay(FootballPlay|array|null $lastPlay): self
    {
        $self = clone $this;
        $self['lastPlay'] = $lastPlay;

        return $self;
    }

    /**
     * The teams this answer names, by team ID.
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
     * The players this answer names, by player ID.
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
