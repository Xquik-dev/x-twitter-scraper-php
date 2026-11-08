<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlay;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ScoreShape = array{
 *   homePoints: int|null,
 *   awayPoints: int|null,
 *   points: int|null,
 * }
 */
final class Score implements BaseModel
{
    /** @use SdkModel<ScoreShape> */
    use SdkModel;

    /**
     * The home team's score once this scoring play counted.
     */
    #[Required]
    public ?int $homePoints;

    /**
     * The away team's score once this scoring play counted.
     */
    #[Required]
    public ?int $awayPoints;

    /**
     * The points the play scored.
     */
    #[Required]
    public ?int $points;

    /**
     * `new Score()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Score::with(homePoints: ..., awayPoints: ..., points: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Score)->withHomePoints(...)->withAwayPoints(...)->withPoints(...)
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
    public static function with(?int $homePoints, ?int $awayPoints, ?int $points): self
    {
        $self = new self;

        $self['homePoints'] = $homePoints;
        $self['awayPoints'] = $awayPoints;
        $self['points'] = $points;

        return $self;
    }

    /**
     * The home team's score once this scoring play counted.
     */
    public function withHomePoints(?int $homePoints): self
    {
        $self = clone $this;
        $self['homePoints'] = $homePoints;

        return $self;
    }

    /**
     * The away team's score once this scoring play counted.
     */
    public function withAwayPoints(?int $awayPoints): self
    {
        $self = clone $this;
        $self['awayPoints'] = $awayPoints;

        return $self;
    }

    /**
     * The points the play scored.
     */
    public function withPoints(?int $points): self
    {
        $self = clone $this;
        $self['points'] = $points;

        return $self;
    }
}
