<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FootballTeamBoxShape = array{
 *   teamID: string|null,
 *   totals: FootballTeamTotals|array<string,mixed>|null,
 *   players: list<FootballPlayerStats|array<string,mixed>>,
 * }
 */
final class FootballTeamBox implements BaseModel
{
    /** @use SdkModel<FootballTeamBoxShape> */
    use SdkModel;

    /**
     * The team these totals belong to, a key of teams.
     */
    #[Required('teamId')]
    public ?string $teamID;

    /**
     * The team's totals, or null before kickoff.
     */
    #[Required]
    public ?FootballTeamTotals $totals;

    /**
     * Each player with stats, 1 entry per player.
     *
     * @var list<FootballPlayerStats> $players
     */
    #[Required(list: FootballPlayerStats::class)]
    public array $players;

    /**
     * `new FootballTeamBox()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballTeamBox::with(teamID: ..., totals: ..., players: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballTeamBox)->withTeamID(...)->withTotals(...)->withPlayers(...)
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
     * @param FootballTeamTotals|array<string,mixed>|null $totals
     * @param list<FootballPlayerStats|array<string,mixed>> $players
     */
    public static function with(?string $teamID, FootballTeamTotals|array|null $totals, array $players): self
    {
        $self = new self;

        $self['teamID'] = $teamID;
        $self['totals'] = $totals;
        $self['players'] = $players;

        return $self;
    }

    /**
     * The team these totals belong to, a key of teams.
     */
    public function withTeamID(?string $teamID): self
    {
        $self = clone $this;
        $self['teamID'] = $teamID;

        return $self;
    }

    /**
     * The team's totals, or null before kickoff.
     *
     * @param FootballTeamTotals|array<string,mixed>|null $totals
     */
    public function withTotals(FootballTeamTotals|array|null $totals): self
    {
        $self = clone $this;
        $self['totals'] = $totals;

        return $self;
    }

    /**
     * Each player with stats, 1 entry per player.
     *
     * @param list<FootballPlayerStats|array<string,mixed>> $players
     */
    public function withPlayers(array $players): self
    {
        $self = clone $this;
        $self['players'] = $players;

        return $self;
    }
}
