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
 * @phpstan-type FootballSideShape = array{
 *   teamID: string|null,
 *   points: int|null,
 *   timeoutsLeft: int|null,
 * }
 */
final class FootballSide implements BaseModel
{
    /** @use SdkModel<FootballSideShape> */
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
     * The timeouts the team has left.
     */
    #[Required]
    public ?int $timeoutsLeft;

    /**
     * `new FootballSide()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballSide::with(teamID: ..., points: ..., timeoutsLeft: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballSide)->withTeamID(...)->withPoints(...)->withTimeoutsLeft(...)
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
    public static function with(?string $teamID, ?int $points, ?int $timeoutsLeft): self
    {
        $self = new self;

        $self['teamID'] = $teamID;
        $self['points'] = $points;
        $self['timeoutsLeft'] = $timeoutsLeft;

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

    /**
     * The timeouts the team has left.
     */
    public function withTimeoutsLeft(?int $timeoutsLeft): self
    {
        $self = clone $this;
        $self['timeoutsLeft'] = $timeoutsLeft;

        return $self;
    }
}
