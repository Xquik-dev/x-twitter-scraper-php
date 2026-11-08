<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballScheduleGame\Odds;

/**
 * @phpstan-type FootballScheduleGameShape = array{
 *   id: string,
 *   seasonType: string|null,
 *   week: int|null,
 *   startsAt: \DateTimeInterface|null,
 *   status: string|null,
 *   clock: string|null,
 *   quarter: int|null,
 *   home: FootballTeamScore|array<string,mixed>,
 *   away: FootballTeamScore|array<string,mixed>,
 *   teamIDs: list<string>,
 *   periods: list<FootballSchedulePeriod|array<string,mixed>>,
 *   odds: Odds|array<string,mixed>|null,
 * }
 */
final class FootballScheduleGame implements BaseModel
{
    /** @use SdkModel<FootballScheduleGameShape> */
    use SdkModel;

    /**
     * The game ID the other sports routes take.
     */
    #[Required]
    public string $id;

    /**
     * This game's part of the season, such as RegularSeason.
     */
    #[Required]
    public ?string $seasonType;

    /**
     * This game's week of the season.
     */
    #[Required]
    public ?int $week;

    /**
     * This game's kickoff time in UTC, or null when Xquik cannot read it.
     */
    #[Required]
    public ?\DateTimeInterface $startsAt;

    /**
     * This game's status from X, such as Scheduled, InProgress or Closed.
     */
    #[Required]
    public ?string $status;

    /**
     * This game's clock, as X writes it.
     */
    #[Required]
    public ?string $clock;

    /**
     * This game's current or last quarter.
     */
    #[Required]
    public ?int $quarter;

    /**
     * A team's side of a game & its points.
     */
    #[Required]
    public FootballTeamScore $home;

    /**
     * A team's side of a game & its points.
     */
    #[Required]
    public FootballTeamScore $away;

    /**
     * The game's teams, keys of teams.
     *
     * @var list<string> $teamIDs
     */
    #[Required('teamIds', list: 'string')]
    public array $teamIDs;

    /**
     * The periods played so far.
     *
     * @var list<FootballSchedulePeriod> $periods
     */
    #[Required(list: FootballSchedulePeriod::class)]
    public array $periods;

    /**
     * Betting odds for each team, or null when X has none.
     */
    #[Required]
    public ?Odds $odds;

    /**
     * `new FootballScheduleGame()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballScheduleGame::with(id: ..., seasonType: ..., week: ..., startsAt: ..., status: ..., clock: ..., quarter: ..., home: ..., away: ..., teamIDs: ..., periods: ..., odds: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballScheduleGame)->withId(...)->withSeasonType(...)->withWeek(...)->withStartsAt(...)->withStatus(...)->withClock(...)->withQuarter(...)->withHome(...)->withAway(...)->withTeamIDs(...)->withPeriods(...)->withOdds(...)
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
     * @param FootballTeamScore|array<string,mixed> $home
     * @param FootballTeamScore|array<string,mixed> $away
     * @param list<string> $teamIDs
     * @param list<FootballSchedulePeriod|array<string,mixed>> $periods
     * @param Odds|array<string,mixed>|null $odds
     */
    public static function with(string $id, ?string $seasonType, ?int $week, ?\DateTimeInterface $startsAt, ?string $status, ?string $clock, ?int $quarter, FootballTeamScore|array $home, FootballTeamScore|array $away, array $teamIDs, array $periods, Odds|array|null $odds): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['seasonType'] = $seasonType;
        $self['week'] = $week;
        $self['startsAt'] = $startsAt;
        $self['status'] = $status;
        $self['clock'] = $clock;
        $self['quarter'] = $quarter;
        $self['home'] = $home;
        $self['away'] = $away;
        $self['teamIDs'] = $teamIDs;
        $self['periods'] = $periods;
        $self['odds'] = $odds;

        return $self;
    }

    /**
     * The game ID the other sports routes take.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * This game's part of the season, such as RegularSeason.
     */
    public function withSeasonType(?string $seasonType): self
    {
        $self = clone $this;
        $self['seasonType'] = $seasonType;

        return $self;
    }

    /**
     * This game's week of the season.
     */
    public function withWeek(?int $week): self
    {
        $self = clone $this;
        $self['week'] = $week;

        return $self;
    }

    /**
     * This game's kickoff time in UTC, or null when Xquik cannot read it.
     */
    public function withStartsAt(?\DateTimeInterface $startsAt): self
    {
        $self = clone $this;
        $self['startsAt'] = $startsAt;

        return $self;
    }

    /**
     * This game's status from X, such as Scheduled, InProgress or Closed.
     */
    public function withStatus(?string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * This game's clock, as X writes it.
     */
    public function withClock(?string $clock): self
    {
        $self = clone $this;
        $self['clock'] = $clock;

        return $self;
    }

    /**
     * This game's current or last quarter.
     */
    public function withQuarter(?int $quarter): self
    {
        $self = clone $this;
        $self['quarter'] = $quarter;

        return $self;
    }

    /**
     * A team's side of a game & its points.
     *
     * @param FootballTeamScore|array<string,mixed> $home
     */
    public function withHome(FootballTeamScore|array $home): self
    {
        $self = clone $this;
        $self['home'] = $home;

        return $self;
    }

    /**
     * A team's side of a game & its points.
     *
     * @param FootballTeamScore|array<string,mixed> $away
     */
    public function withAway(FootballTeamScore|array $away): self
    {
        $self = clone $this;
        $self['away'] = $away;

        return $self;
    }

    /**
     * The game's teams, keys of teams.
     *
     * @param list<string> $teamIDs
     */
    public function withTeamIDs(array $teamIDs): self
    {
        $self = clone $this;
        $self['teamIDs'] = $teamIDs;

        return $self;
    }

    /**
     * The periods played so far.
     *
     * @param list<FootballSchedulePeriod|array<string,mixed>> $periods
     */
    public function withPeriods(array $periods): self
    {
        $self = clone $this;
        $self['periods'] = $periods;

        return $self;
    }

    /**
     * Betting odds for each team, or null when X has none.
     *
     * @param Odds|array<string,mixed>|null $odds
     */
    public function withOdds(Odds|array|null $odds): self
    {
        $self = clone $this;
        $self['odds'] = $odds;

        return $self;
    }
}
