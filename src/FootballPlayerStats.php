<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FootballPlayerStats\Conversions;
use XTwitterScraper\FootballPlayerStats\Defense;
use XTwitterScraper\FootballPlayerStats\ExtraPoints;
use XTwitterScraper\FootballPlayerStats\FieldGoals;
use XTwitterScraper\FootballPlayerStats\Punts;
use XTwitterScraper\FootballPlayerStats\Receiving;

/**
 * @phpstan-type FootballPlayerStatsShape = array{
 *   playerID: string|null,
 *   passing?: FootballPassingStats|array<string,mixed>|null,
 *   rushing?: FootballRushingStats|array<string,mixed>|null,
 *   receiving?: Receiving|array<string,mixed>|null,
 *   defense?: Defense|array<string,mixed>|null,
 *   fumbles?: FootballFumbleStats|array<string,mixed>|null,
 *   kickReturns?: FootballReturnStats|array<string,mixed>|null,
 *   puntReturns?: FootballReturnStats|array<string,mixed>|null,
 *   interceptionReturns?: FootballReturnStats|array<string,mixed>|null,
 *   punts?: Punts|array<string,mixed>|null,
 *   fieldGoals?: FieldGoals|array<string,mixed>|null,
 *   extraPoints?: ExtraPoints|array<string,mixed>|null,
 *   conversions?: Conversions|array<string,mixed>|null,
 * }
 */
final class FootballPlayerStats implements BaseModel
{
    /** @use SdkModel<FootballPlayerStatsShape> */
    use SdkModel;

    /**
     * The player these stats belong to, a key of players.
     */
    #[Required('playerId')]
    public ?string $playerID;

    /**
     * Passing stats.
     */
    #[Optional]
    public ?FootballPassingStats $passing;

    /**
     * Rushing stats.
     */
    #[Optional]
    public ?FootballRushingStats $rushing;

    /**
     * Receiving stats.
     */
    #[Optional]
    public ?Receiving $receiving;

    /**
     * Defensive stats.
     */
    #[Optional]
    public ?Defense $defense;

    /**
     * Fumble stats.
     */
    #[Optional]
    public ?FootballFumbleStats $fumbles;

    /**
     * Kick, punt or interception return stats.
     */
    #[Optional]
    public ?FootballReturnStats $kickReturns;

    /**
     * Kick, punt or interception return stats.
     */
    #[Optional]
    public ?FootballReturnStats $puntReturns;

    /**
     * Kick, punt or interception return stats.
     */
    #[Optional]
    public ?FootballReturnStats $interceptionReturns;

    /**
     * Punting stats.
     */
    #[Optional]
    public ?Punts $punts;

    /**
     * Field goal stats.
     */
    #[Optional]
    public ?FieldGoals $fieldGoals;

    /**
     * Extra point kicks.
     */
    #[Optional]
    public ?ExtraPoints $extraPoints;

    /**
     * 2-point conversions.
     */
    #[Optional]
    public ?Conversions $conversions;

    /**
     * `new FootballPlayerStats()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPlayerStats::with(playerID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPlayerStats)->withPlayerID(...)
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
     * @param FootballPassingStats|array<string,mixed>|null $passing
     * @param FootballRushingStats|array<string,mixed>|null $rushing
     * @param Receiving|array<string,mixed>|null $receiving
     * @param Defense|array<string,mixed>|null $defense
     * @param FootballFumbleStats|array<string,mixed>|null $fumbles
     * @param FootballReturnStats|array<string,mixed>|null $kickReturns
     * @param FootballReturnStats|array<string,mixed>|null $puntReturns
     * @param FootballReturnStats|array<string,mixed>|null $interceptionReturns
     * @param Punts|array<string,mixed>|null $punts
     * @param FieldGoals|array<string,mixed>|null $fieldGoals
     * @param ExtraPoints|array<string,mixed>|null $extraPoints
     * @param Conversions|array<string,mixed>|null $conversions
     */
    public static function with(?string $playerID, FootballPassingStats|array|null $passing = null, FootballRushingStats|array|null $rushing = null, Receiving|array|null $receiving = null, Defense|array|null $defense = null, FootballFumbleStats|array|null $fumbles = null, FootballReturnStats|array|null $kickReturns = null, FootballReturnStats|array|null $puntReturns = null, FootballReturnStats|array|null $interceptionReturns = null, Punts|array|null $punts = null, FieldGoals|array|null $fieldGoals = null, ExtraPoints|array|null $extraPoints = null, Conversions|array|null $conversions = null): self
    {
        $self = new self;

        $self['playerID'] = $playerID;

        null !== $passing && $self['passing'] = $passing;
        null !== $rushing && $self['rushing'] = $rushing;
        null !== $receiving && $self['receiving'] = $receiving;
        null !== $defense && $self['defense'] = $defense;
        null !== $fumbles && $self['fumbles'] = $fumbles;
        null !== $kickReturns && $self['kickReturns'] = $kickReturns;
        null !== $puntReturns && $self['puntReturns'] = $puntReturns;
        null !== $interceptionReturns && $self['interceptionReturns'] = $interceptionReturns;
        null !== $punts && $self['punts'] = $punts;
        null !== $fieldGoals && $self['fieldGoals'] = $fieldGoals;
        null !== $extraPoints && $self['extraPoints'] = $extraPoints;
        null !== $conversions && $self['conversions'] = $conversions;

        return $self;
    }

    /**
     * The player these stats belong to, a key of players.
     */
    public function withPlayerID(?string $playerID): self
    {
        $self = clone $this;
        $self['playerID'] = $playerID;

        return $self;
    }

    /**
     * Passing stats.
     *
     * @param FootballPassingStats|array<string,mixed>|null $passing
     */
    public function withPassing(FootballPassingStats|array|null $passing): self
    {
        $self = clone $this;
        $self['passing'] = $passing;

        return $self;
    }

    /**
     * Rushing stats.
     *
     * @param FootballRushingStats|array<string,mixed>|null $rushing
     */
    public function withRushing(FootballRushingStats|array|null $rushing): self
    {
        $self = clone $this;
        $self['rushing'] = $rushing;

        return $self;
    }

    /**
     * Receiving stats.
     *
     * @param Receiving|array<string,mixed>|null $receiving
     */
    public function withReceiving(Receiving|array|null $receiving): self
    {
        $self = clone $this;
        $self['receiving'] = $receiving;

        return $self;
    }

    /**
     * Defensive stats.
     *
     * @param Defense|array<string,mixed>|null $defense
     */
    public function withDefense(Defense|array|null $defense): self
    {
        $self = clone $this;
        $self['defense'] = $defense;

        return $self;
    }

    /**
     * Fumble stats.
     *
     * @param FootballFumbleStats|array<string,mixed>|null $fumbles
     */
    public function withFumbles(FootballFumbleStats|array|null $fumbles): self
    {
        $self = clone $this;
        $self['fumbles'] = $fumbles;

        return $self;
    }

    /**
     * Kick, punt or interception return stats.
     *
     * @param FootballReturnStats|array<string,mixed>|null $kickReturns
     */
    public function withKickReturns(FootballReturnStats|array|null $kickReturns): self
    {
        $self = clone $this;
        $self['kickReturns'] = $kickReturns;

        return $self;
    }

    /**
     * Kick, punt or interception return stats.
     *
     * @param FootballReturnStats|array<string,mixed>|null $puntReturns
     */
    public function withPuntReturns(FootballReturnStats|array|null $puntReturns): self
    {
        $self = clone $this;
        $self['puntReturns'] = $puntReturns;

        return $self;
    }

    /**
     * Kick, punt or interception return stats.
     *
     * @param FootballReturnStats|array<string,mixed>|null $interceptionReturns
     */
    public function withInterceptionReturns(FootballReturnStats|array|null $interceptionReturns): self
    {
        $self = clone $this;
        $self['interceptionReturns'] = $interceptionReturns;

        return $self;
    }

    /**
     * Punting stats.
     *
     * @param Punts|array<string,mixed>|null $punts
     */
    public function withPunts(Punts|array|null $punts): self
    {
        $self = clone $this;
        $self['punts'] = $punts;

        return $self;
    }

    /**
     * Field goal stats.
     *
     * @param FieldGoals|array<string,mixed>|null $fieldGoals
     */
    public function withFieldGoals(FieldGoals|array|null $fieldGoals): self
    {
        $self = clone $this;
        $self['fieldGoals'] = $fieldGoals;

        return $self;
    }

    /**
     * Extra point kicks.
     *
     * @param ExtraPoints|array<string,mixed>|null $extraPoints
     */
    public function withExtraPoints(ExtraPoints|array|null $extraPoints): self
    {
        $self = clone $this;
        $self['extraPoints'] = $extraPoints;

        return $self;
    }

    /**
     * 2-point conversions.
     *
     * @param Conversions|array<string,mixed>|null $conversions
     */
    public function withConversions(Conversions|array|null $conversions): self
    {
        $self = clone $this;
        $self['conversions'] = $conversions;

        return $self;
    }
}
