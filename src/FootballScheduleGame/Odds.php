<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballScheduleGame;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballOdds;

/**
 * @phpstan-type OddsShape = array{
 *   home: FootballOdds|array<string,mixed>,
 *   away: FootballOdds|array<string,mixed>,
 * }
 */
final class Odds implements BaseModel
{
    /** @use SdkModel<OddsShape> */
    use SdkModel;

    /**
     * Betting odds titles for 1 team, as X shows them.
     */
    #[Required]
    public FootballOdds $home;

    /**
     * Betting odds titles for 1 team, as X shows them.
     */
    #[Required]
    public FootballOdds $away;

    /**
     * `new Odds()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Odds::with(home: ..., away: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Odds)->withHome(...)->withAway(...)
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
     * @param FootballOdds|array<string,mixed> $home
     * @param FootballOdds|array<string,mixed> $away
     */
    public static function with(FootballOdds|array $home, FootballOdds|array $away): self
    {
        $self = new self;

        $self['home'] = $home;
        $self['away'] = $away;

        return $self;
    }

    /**
     * Betting odds titles for 1 team, as X shows them.
     *
     * @param FootballOdds|array<string,mixed> $home
     */
    public function withHome(FootballOdds|array $home): self
    {
        $self = clone $this;
        $self['home'] = $home;

        return $self;
    }

    /**
     * Betting odds titles for 1 team, as X shows them.
     *
     * @param FootballOdds|array<string,mixed> $away
     */
    public function withAway(FootballOdds|array $away): self
    {
        $self = clone $this;
        $self['away'] = $away;

        return $self;
    }
}
