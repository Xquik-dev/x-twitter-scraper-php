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
 * @phpstan-type FootballPeriodShape = array{
 *   type: string|null,
 *   number: int|null,
 *   sequence: int|null,
 *   homePoints: int|null,
 *   awayPoints: int|null,
 * }
 */
final class FootballPeriod implements BaseModel
{
    /** @use SdkModel<FootballPeriodShape> */
    use SdkModel;

    /**
     * X's name for the period, such as Quarter.
     */
    #[Required]
    public ?string $type;

    /**
     * The period's number, or null when X sends no digits.
     */
    #[Required]
    public ?int $number;

    /**
     * The period's place in the game, from 1.
     */
    #[Required]
    public ?int $sequence;

    /**
     * The home team's points in the period.
     */
    #[Required]
    public ?int $homePoints;

    /**
     * The away team's points in the period.
     */
    #[Required]
    public ?int $awayPoints;

    /**
     * `new FootballPeriod()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballPeriod::with(type: ..., number: ..., sequence: ..., homePoints: ..., awayPoints: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballPeriod)->withType(...)->withNumber(...)->withSequence(...)->withHomePoints(...)->withAwayPoints(...)
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
    public static function with(?string $type, ?int $number, ?int $sequence, ?int $homePoints, ?int $awayPoints): self
    {
        $self = new self;

        $self['type'] = $type;
        $self['number'] = $number;
        $self['sequence'] = $sequence;
        $self['homePoints'] = $homePoints;
        $self['awayPoints'] = $awayPoints;

        return $self;
    }

    /**
     * X's name for the period, such as Quarter.
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The period's number, or null when X sends no digits.
     */
    public function withNumber(?int $number): self
    {
        $self = clone $this;
        $self['number'] = $number;

        return $self;
    }

    /**
     * The period's place in the game, from 1.
     */
    public function withSequence(?int $sequence): self
    {
        $self = clone $this;
        $self['sequence'] = $sequence;

        return $self;
    }

    /**
     * The home team's points in the period.
     */
    public function withHomePoints(?int $homePoints): self
    {
        $self = clone $this;
        $self['homePoints'] = $homePoints;

        return $self;
    }

    /**
     * The away team's points in the period.
     */
    public function withAwayPoints(?int $awayPoints): self
    {
        $self = clone $this;
        $self['awayPoints'] = $awayPoints;

        return $self;
    }
}
