<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballTeamTotals;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PenaltiesShape = array{
 *   count: int|null,
 *   yards: int|null,
 * }
 */
final class Penalties implements BaseModel
{
    /** @use SdkModel<PenaltiesShape> */
    use SdkModel;

    /**
     * Penalties.
     */
    #[Required]
    public ?int $count;

    /**
     * Penalty yards.
     */
    #[Required]
    public ?int $yards;

    /**
     * `new Penalties()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Penalties::with(count: ..., yards: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Penalties)->withCount(...)->withYards(...)
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
    public static function with(?int $count, ?int $yards): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['yards'] = $yards;

        return $self;
    }

    /**
     * Penalties.
     */
    public function withCount(?int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Penalty yards.
     */
    public function withYards(?int $yards): self
    {
        $self = clone $this;
        $self['yards'] = $yards;

        return $self;
    }
}
