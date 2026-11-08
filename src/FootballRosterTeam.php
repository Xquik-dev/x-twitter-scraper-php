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
 * @phpstan-type FootballRosterTeamShape = array{
 *   teamID: string,
 *   playerIDs: list<string>,
 * }
 */
final class FootballRosterTeam implements BaseModel
{
    /** @use SdkModel<FootballRosterTeamShape> */
    use SdkModel;

    /**
     * The team this roster belongs to, a key of teams.
     */
    #[Required('teamId')]
    public string $teamID;

    /**
     * The team's players in X's order, keys of players.
     *
     * @var list<string> $playerIDs
     */
    #[Required('playerIds', list: 'string')]
    public array $playerIDs;

    /**
     * `new FootballRosterTeam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballRosterTeam::with(teamID: ..., playerIDs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballRosterTeam)->withTeamID(...)->withPlayerIDs(...)
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
     * @param list<string> $playerIDs
     */
    public static function with(string $teamID, array $playerIDs): self
    {
        $self = new self;

        $self['teamID'] = $teamID;
        $self['playerIDs'] = $playerIDs;

        return $self;
    }

    /**
     * The team this roster belongs to, a key of teams.
     */
    public function withTeamID(string $teamID): self
    {
        $self = clone $this;
        $self['teamID'] = $teamID;

        return $self;
    }

    /**
     * The team's players in X's order, keys of players.
     *
     * @param list<string> $playerIDs
     */
    public function withPlayerIDs(array $playerIDs): self
    {
        $self = clone $this;
        $self['playerIDs'] = $playerIDs;

        return $self;
    }
}
