<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SportsGameAudience\TeamPicks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TeamsShape = array{
 *   teamID: string,
 *   count: int|null,
 * }
 */
final class Teams implements BaseModel
{
    /** @use SdkModel<TeamsShape> */
    use SdkModel;

    /**
     * The team ID, a key in teams.
     */
    #[Required('teamId')]
    public string $teamID;

    /**
     * How many people picked this team.
     */
    #[Required]
    public ?int $count;

    /**
     * `new Teams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Teams::with(teamID: ..., count: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Teams)->withTeamID(...)->withCount(...)
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
    public static function with(string $teamID, ?int $count): self
    {
        $self = new self;

        $self['teamID'] = $teamID;
        $self['count'] = $count;

        return $self;
    }

    /**
     * The team ID, a key in teams.
     */
    public function withTeamID(string $teamID): self
    {
        $self = clone $this;
        $self['teamID'] = $teamID;

        return $self;
    }

    /**
     * How many people picked this team.
     */
    public function withCount(?int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }
}
