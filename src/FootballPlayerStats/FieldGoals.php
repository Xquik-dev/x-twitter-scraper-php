<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlayerStats;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FieldGoalsShape = array{
 *   attempts: int|null,
 *   longest: int|null,
 *   made: int|null,
 * }
 */
final class FieldGoals implements BaseModel
{
    /** @use SdkModel<FieldGoalsShape> */
    use SdkModel;

    /**
     * Field goals tried.
     */
    #[Required]
    public ?int $attempts;

    /**
     * The longest made field goal, in yards.
     */
    #[Required]
    public ?int $longest;

    /**
     * Field goals made.
     */
    #[Required]
    public ?int $made;

    /**
     * `new FieldGoals()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FieldGoals::with(attempts: ..., longest: ..., made: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FieldGoals)->withAttempts(...)->withLongest(...)->withMade(...)
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
    public static function with(?int $attempts, ?int $longest, ?int $made): self
    {
        $self = new self;

        $self['attempts'] = $attempts;
        $self['longest'] = $longest;
        $self['made'] = $made;

        return $self;
    }

    /**
     * Field goals tried.
     */
    public function withAttempts(?int $attempts): self
    {
        $self = clone $this;
        $self['attempts'] = $attempts;

        return $self;
    }

    /**
     * The longest made field goal, in yards.
     */
    public function withLongest(?int $longest): self
    {
        $self = clone $this;
        $self['longest'] = $longest;

        return $self;
    }

    /**
     * Field goals made.
     */
    public function withMade(?int $made): self
    {
        $self = clone $this;
        $self['made'] = $made;

        return $self;
    }
}
