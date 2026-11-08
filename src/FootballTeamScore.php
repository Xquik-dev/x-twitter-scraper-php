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
 * @phpstan-type FootballTeamScoreShape = array{
 *   teamID: string|null,
 *   points: int|null,
 * }
 */
final class FootballTeamScore implements BaseModel
{
    /** @use SdkModel<FootballTeamScoreShape> */
    use SdkModel;

    /**
     * The team, a key of teams.
     */
    #[Required('teamId')]
    public ?string $teamID;

    /**
     * The team's points so far.
     */
    #[Required]
    public ?int $points;

    /**
     * `new FootballTeamScore()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballTeamScore::with(teamID: ..., points: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballTeamScore)->withTeamID(...)->withPoints(...)
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
     */
    public static function with(?string $teamID, ?int $points): self
    {
        $self = new self;

        $self['teamID'] = $teamID;
        $self['points'] = $points;

        return $self;
    }

    /**
     * The team, a key of teams.
     */
    public function withTeamID(?string $teamID): self
    {
        $self = clone $this;
        $self['teamID'] = $teamID;

        return $self;
    }

    /**
     * The team's points so far.
     */
    public function withPoints(?int $points): self
    {
        $self = clone $this;
        $self['points'] = $points;

        return $self;
    }
}
