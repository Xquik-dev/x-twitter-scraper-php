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
 * A team's rank in X's college football poll.
 *
 * @phpstan-type FootballPollRankingShape = array{
 *   teamID: string|null,
 *   rank: int|null,
 * }
 */
final class FootballPollRanking implements BaseModel
{
    /** @use SdkModel<FootballPollRankingShape> */
    use SdkModel;

    /**
     * The ranked team, a key of teams.
     */
    #[Required('teamId')]
    public ?string $teamID;

    /**
     * The team's rank, where 1 is the top.
     */
    #[Required]
    public ?int $rank;

    /**
     * `new FootballPollRanking()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPollRanking::with(teamID: ..., rank: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPollRanking)->withTeamID(...)->withRank(...)
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
    public static function with(?string $teamID, ?int $rank): self
    {
        $self = new self;

        $self['teamID'] = $teamID;
        $self['rank'] = $rank;

        return $self;
    }

    /**
     * The ranked team, a key of teams.
     */
    public function withTeamID(?string $teamID): self
    {
        $self = clone $this;
        $self['teamID'] = $teamID;

        return $self;
    }

    /**
     * The team's rank, where 1 is the top.
     */
    public function withRank(?int $rank): self
    {
        $self = clone $this;
        $self['rank'] = $rank;

        return $self;
    }
}
