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
 * @phpstan-type ThirdDownsShape = array{
 *   attempts: int|null,
 *   successes: int|null,
 * }
 */
final class ThirdDowns implements BaseModel
{
    /** @use SdkModel<ThirdDownsShape> */
    use SdkModel;

    /**
     * Third downs tried.
     */
    #[Required]
    public ?int $attempts;

    /**
     * Third downs converted.
     */
    #[Required]
    public ?int $successes;

    /**
     * `new ThirdDowns()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ThirdDowns::with(attempts: ..., successes: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ThirdDowns)->withAttempts(...)->withSuccesses(...)
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
    public static function with(?int $attempts, ?int $successes): self
    {
        $self = new self;

        $self['attempts'] = $attempts;
        $self['successes'] = $successes;

        return $self;
    }

    /**
     * Third downs tried.
     */
    public function withAttempts(?int $attempts): self
    {
        $self = clone $this;
        $self['attempts'] = $attempts;

        return $self;
    }

    /**
     * Third downs converted.
     */
    public function withSuccesses(?int $successes): self
    {
        $self = clone $this;
        $self['successes'] = $successes;

        return $self;
    }
}
