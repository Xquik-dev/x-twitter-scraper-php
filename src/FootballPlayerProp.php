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
 * @phpstan-type FootballPlayerPropShape = array{
 *   playerID: string|null,
 *   rank: float|null,
 *   line: float|null,
 *   odds: float|null,
 *   alternateOdds: float|null,
 *   openForBetting: bool|null,
 * }
 */
final class FootballPlayerProp implements BaseModel
{
    /** @use SdkModel<FootballPlayerPropShape> */
    use SdkModel;

    /**
     * The player the line is for, a key of players.
     */
    #[Required('playerId')]
    public ?string $playerID;

    /**
     * The line's place in its category, from 1.
     */
    #[Required]
    public ?float $rank;

    /**
     * The line the odds price, such as 248.5 yards. Null when the prop has no line, such as the first touchdown scorer.
     */
    #[Required]
    public ?float $line;

    /**
     * The American odds X shows first, such as -115 or 240.
     */
    #[Required]
    public ?float $odds;

    /**
     * The American odds X shows second. Null for a prop with 1 price.
     */
    #[Required]
    public ?float $alternateOdds;

    /**
     * Whether the sportsbook takes bets on the line.
     */
    #[Required]
    public ?bool $openForBetting;

    /**
     * `new FootballPlayerProp()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPlayerProp::with(playerID: ..., rank: ..., line: ..., odds: ..., alternateOdds: ..., openForBetting: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPlayerProp)->withPlayerID(...)->withRank(...)->withLine(...)->withOdds(...)->withAlternateOdds(...)->withOpenForBetting(...)
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
    public static function with(?string $playerID, ?float $rank, ?float $line, ?float $odds, ?float $alternateOdds, ?bool $openForBetting): self
    {
        $self = new self;

        $self['playerID'] = $playerID;
        $self['rank'] = $rank;
        $self['line'] = $line;
        $self['odds'] = $odds;
        $self['alternateOdds'] = $alternateOdds;
        $self['openForBetting'] = $openForBetting;

        return $self;
    }

    /**
     * The player the line is for, a key of players.
     */
    public function withPlayerID(?string $playerID): self
    {
        $self = clone $this;
        $self['playerID'] = $playerID;

        return $self;
    }

    /**
     * The line's place in its category, from 1.
     */
    public function withRank(?float $rank): self
    {
        $self = clone $this;
        $self['rank'] = $rank;

        return $self;
    }

    /**
     * The line the odds price, such as 248.5 yards. Null when the prop has no line, such as the first touchdown scorer.
     */
    public function withLine(?float $line): self
    {
        $self = clone $this;
        $self['line'] = $line;

        return $self;
    }

    /**
     * The American odds X shows first, such as -115 or 240.
     */
    public function withOdds(?float $odds): self
    {
        $self = clone $this;
        $self['odds'] = $odds;

        return $self;
    }

    /**
     * The American odds X shows second. Null for a prop with 1 price.
     */
    public function withAlternateOdds(?float $alternateOdds): self
    {
        $self = clone $this;
        $self['alternateOdds'] = $alternateOdds;

        return $self;
    }

    /**
     * Whether the sportsbook takes bets on the line.
     */
    public function withOpenForBetting(?bool $openForBetting): self
    {
        $self = clone $this;
        $self['openForBetting'] = $openForBetting;

        return $self;
    }
}
