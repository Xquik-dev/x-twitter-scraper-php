<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\Creator;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BirthdateShape = array{
 *   day?: int|null,
 *   month?: int|null,
 *   year?: int|null,
 * }
 */
final class Birthdate implements BaseModel
{
    /** @use SdkModel<BirthdateShape> */
    use SdkModel;

    #[Optional]
    public ?int $day;

    #[Optional]
    public ?int $month;

    #[Optional]
    public ?int $year;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $day = null, ?int $month = null, ?int $year = null): self
    {
        $self = new self;

        null !== $day && $self['day'] = $day;
        null !== $month && $self['month'] = $month;
        null !== $year && $self['year'] = $year;

        return $self;
    }

    public function withDay(?int $day): self
    {
        $self = clone $this;
        $self['day'] = $day;

        return $self;
    }

    public function withMonth(?int $month): self
    {
        $self = clone $this;
        $self['month'] = $month;

        return $self;
    }

    public function withYear(?int $year): self
    {
        $self = clone $this;
        $self['year'] = $year;

        return $self;
    }
}
