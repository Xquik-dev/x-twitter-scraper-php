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
 * @phpstan-type FootballFumbleStatsShape = array{
 *   lost: int|null,
 *   opponentRecoveryTouchdowns: int|null,
 *   ownRecoveryTouchdowns: int|null,
 * }
 */
final class FootballFumbleStats implements BaseModel
{
    /** @use SdkModel<FootballFumbleStatsShape> */
    use SdkModel;

    /**
     * Fumbles the other team recovered.
     */
    #[Required]
    public ?int $lost;

    /**
     * Touchdowns scored after recovering the other team's fumble.
     */
    #[Required]
    public ?int $opponentRecoveryTouchdowns;

    /**
     * Touchdowns scored after recovering an own fumble.
     */
    #[Required]
    public ?int $ownRecoveryTouchdowns;

    /**
     * `new FootballFumbleStats()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballFumbleStats::with(lost: ..., opponentRecoveryTouchdowns: ..., ownRecoveryTouchdowns: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballFumbleStats)->withLost(...)->withOpponentRecoveryTouchdowns(...)->withOwnRecoveryTouchdowns(...)
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
    public static function with(?int $lost, ?int $opponentRecoveryTouchdowns, ?int $ownRecoveryTouchdowns): self
    {
        $self = new self;

        $self['lost'] = $lost;
        $self['opponentRecoveryTouchdowns'] = $opponentRecoveryTouchdowns;
        $self['ownRecoveryTouchdowns'] = $ownRecoveryTouchdowns;

        return $self;
    }

    /**
     * Fumbles the other team recovered.
     */
    public function withLost(?int $lost): self
    {
        $self = clone $this;
        $self['lost'] = $lost;

        return $self;
    }

    /**
     * Touchdowns scored after recovering the other team's fumble.
     */
    public function withOpponentRecoveryTouchdowns(?int $opponentRecoveryTouchdowns): self
    {
        $self = clone $this;
        $self['opponentRecoveryTouchdowns'] = $opponentRecoveryTouchdowns;

        return $self;
    }

    /**
     * Touchdowns scored after recovering an own fumble.
     */
    public function withOwnRecoveryTouchdowns(?int $ownRecoveryTouchdowns): self
    {
        $self = clone $this;
        $self['ownRecoveryTouchdowns'] = $ownRecoveryTouchdowns;

        return $self;
    }
}
