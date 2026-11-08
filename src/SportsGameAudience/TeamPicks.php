<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SportsGameAudience;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SportsGameAudience\TeamPicks\Teams;

/**
 * @phpstan-type TeamPicksShape = array{
 *   total: int|null,
 *   teams: list<Teams|array<string,mixed>>,
 * }
 */
final class TeamPicks implements BaseModel
{
    /** @use SdkModel<TeamPicksShape> */
    use SdkModel;

    /**
     * Picks for every team in the game.
     */
    #[Required]
    public ?int $total;

    /**
     * Picks per team.
     *
     * @var list<Teams> $teams
     */
    #[Required(list: Teams::class)]
    public array $teams;

    /**
     * `new TeamPicks()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TeamPicks::with(total: ..., teams: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TeamPicks)->withTotal(...)->withTeams(...)
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
     * @param list<Teams|array<string,mixed>> $teams
     */
    public static function with(?int $total, array $teams): self
    {
        $self = new self;

        $self['total'] = $total;
        $self['teams'] = $teams;

        return $self;
    }

    /**
     * Picks for every team in the game.
     */
    public function withTotal(?int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    /**
     * Picks per team.
     *
     * @param list<Teams|array<string,mixed>> $teams
     */
    public function withTeams(array $teams): self
    {
        $self = clone $this;
        $self['teams'] = $teams;

        return $self;
    }
}
