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
 * @phpstan-type FootballOddsShape = array{
 *   moneyLine: string|null,
 *   spread: string|null,
 *   total: string|null,
 * }
 */
final class FootballOdds implements BaseModel
{
    /** @use SdkModel<FootballOddsShape> */
    use SdkModel;

    /**
     * The money line. X sends it for the away team only.
     */
    #[Required]
    public ?string $moneyLine;

    /**
     * The point spread.
     */
    #[Required]
    public ?string $spread;

    /**
     * The over or under total.
     */
    #[Required]
    public ?string $total;

    /**
     * `new FootballOdds()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballOdds::with(moneyLine: ..., spread: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballOdds)->withMoneyLine(...)->withSpread(...)->withTotal(...)
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
    public static function with(?string $moneyLine, ?string $spread, ?string $total): self
    {
        $self = new self;

        $self['moneyLine'] = $moneyLine;
        $self['spread'] = $spread;
        $self['total'] = $total;

        return $self;
    }

    /**
     * The money line. X sends it for the away team only.
     */
    public function withMoneyLine(?string $moneyLine): self
    {
        $self = clone $this;
        $self['moneyLine'] = $moneyLine;

        return $self;
    }

    /**
     * The point spread.
     */
    public function withSpread(?string $spread): self
    {
        $self = clone $this;
        $self['spread'] = $spread;

        return $self;
    }

    /**
     * The over or under total.
     */
    public function withTotal(?string $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
