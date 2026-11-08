<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SportsGameAudience\Chat;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type OpensInShape = array{
 *   days: int|null,
 *   hours: int|null,
 *   minutes: int|null,
 * }
 */
final class OpensIn implements BaseModel
{
    /** @use SdkModel<OpensInShape> */
    use SdkModel;

    /**
     * Whole days left.
     */
    #[Required]
    public ?int $days;

    /**
     * Hours left after the days.
     */
    #[Required]
    public ?int $hours;

    /**
     * Minutes left after the hours.
     */
    #[Required]
    public ?int $minutes;

    /**
     * `new OpensIn()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OpensIn::with(days: ..., hours: ..., minutes: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OpensIn)->withDays(...)->withHours(...)->withMinutes(...)
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
    public static function with(?int $days, ?int $hours, ?int $minutes): self
    {
        $self = new self;

        $self['days'] = $days;
        $self['hours'] = $hours;
        $self['minutes'] = $minutes;

        return $self;
    }

    /**
     * Whole days left.
     */
    public function withDays(?int $days): self
    {
        $self = clone $this;
        $self['days'] = $days;

        return $self;
    }

    /**
     * Hours left after the days.
     */
    public function withHours(?int $hours): self
    {
        $self = clone $this;
        $self['hours'] = $hours;

        return $self;
    }

    /**
     * Minutes left after the hours.
     */
    public function withMinutes(?int $minutes): self
    {
        $self = clone $this;
        $self['minutes'] = $minutes;

        return $self;
    }
}
