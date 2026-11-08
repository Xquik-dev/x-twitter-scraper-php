<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SportsGameAudience\Chat;
use XTwitterScraper\SportsGameAudience\League;
use XTwitterScraper\SportsGameAudience\TeamPicks;
use XTwitterScraper\SportsGameAudience\Viewers;

/**
 * @phpstan-type SportsGameAudienceShape = array{
 *   id: string,
 *   league: League|value-of<League>,
 *   viewers: Viewers|array<string,mixed>|null,
 *   teamPicks: TeamPicks|array<string,mixed>,
 *   chat: Chat|array<string,mixed>,
 *   teams: array<string,mixed>,
 * }
 */
final class SportsGameAudience implements BaseModel
{
    /** @use SdkModel<SportsGameAudienceShape> */
    use SdkModel;

    /**
     * The ID of the game, from your request.
     */
    #[Required]
    public string $id;

    /**
     * The game's league, from your request.
     *
     * @var value-of<League> $league
     */
    #[Required(enum: League::class)]
    public string $league;

    /**
     * People watching the game on X at X's last count. Null before X counts any, as before kickoff.
     */
    #[Required]
    public ?Viewers $viewers;

    /**
     * How many people on X picked a team to root for.
     */
    #[Required]
    public TeamPicks $teamPicks;

    /**
     * The game's live chat on X.
     */
    #[Required]
    public Chat $chat;

    /**
     * The game's teams, by team ID. Short name, alternate ID, X account & record are null here.
     *
     * @var array<string,mixed> $teams
     */
    #[Required(map: 'mixed')]
    public array $teams;

    /**
     * `new SportsGameAudience()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SportsGameAudience::with(id: ..., league: ..., viewers: ..., teamPicks: ..., chat: ..., teams: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SportsGameAudience)->withId(...)->withLeague(...)->withViewers(...)->withTeamPicks(...)->withChat(...)->withTeams(...)
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
     * @param Viewers|array<string,mixed>|null $viewers
     * @param TeamPicks|array<string,mixed> $teamPicks
     * @param Chat|array<string,mixed> $chat
     * @param array<string,mixed> $teams
     */
    public static function with(string $id, League|string $league, Viewers|array|null $viewers, TeamPicks|array $teamPicks, Chat|array $chat, array $teams): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['league'] = $league;
        $self['viewers'] = $viewers;
        $self['teamPicks'] = $teamPicks;
        $self['chat'] = $chat;
        $self['teams'] = $teams;

        return $self;
    }

    /**
     * The ID of the game, from your request.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The game's league, from your request.
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
     * People watching the game on X at X's last count. Null before X counts any, as before kickoff.
     *
     * @param Viewers|array<string,mixed>|null $viewers
     */
    public function withViewers(Viewers|array|null $viewers): self
    {
        $self = clone $this;
        $self['viewers'] = $viewers;

        return $self;
    }

    /**
     * How many people on X picked a team to root for.
     *
     * @param TeamPicks|array<string,mixed> $teamPicks
     */
    public function withTeamPicks(TeamPicks|array $teamPicks): self
    {
        $self = clone $this;
        $self['teamPicks'] = $teamPicks;

        return $self;
    }

    /**
     * The game's live chat on X.
     *
     * @param Chat|array<string,mixed> $chat
     */
    public function withChat(Chat|array $chat): self
    {
        $self = clone $this;
        $self['chat'] = $chat;

        return $self;
    }

    /**
     * The game's teams, by team ID. Short name, alternate ID, X account & record are null here.
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
