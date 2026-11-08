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
 * @phpstan-type FootballSchedulePeriodShape = array{
 *   type: string|null,
 * }
 */
final class FootballSchedulePeriod implements BaseModel
{
    /** @use SdkModel<FootballSchedulePeriodShape> */
    use SdkModel;

    /**
     * X's name for the period, such as Quarter.
     */
    #[Required]
    public ?string $type;

    /**
     * `new FootballSchedulePeriod()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FootballSchedulePeriod::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FootballSchedulePeriod)->withType(...)
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
    public static function with(?string $type): self
    {
        $self = new self;

        $self['type'] = $type;

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
}
