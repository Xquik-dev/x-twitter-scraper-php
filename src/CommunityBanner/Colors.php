<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\CommunityBanner;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ColorsShape = array{
 *   percentage: float,
 *   red: int,
 *   green: int,
 *   blue: int,
 * }
 */
final class Colors implements BaseModel
{
    /** @use SdkModel<ColorsShape> */
    use SdkModel;

    /**
     * Share of the banner in this color.
     */
    #[Required]
    public float $percentage;

    /**
     * Red value of the color.
     */
    #[Required]
    public int $red;

    /**
     * Green value of the color.
     */
    #[Required]
    public int $green;

    /**
     * Blue value of the color.
     */
    #[Required]
    public int $blue;

    /**
     * `new Colors()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Colors::with(percentage: ..., red: ..., green: ..., blue: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Colors)->withPercentage(...)->withRed(...)->withGreen(...)->withBlue(...)
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
    public static function with(float $percentage, int $red, int $green, int $blue): self
    {
        $self = new self;

        $self['percentage'] = $percentage;
        $self['red'] = $red;
        $self['green'] = $green;
        $self['blue'] = $blue;

        return $self;
    }

    /**
     * Share of the banner in this color.
     */
    public function withPercentage(float $percentage): self
    {
        $self = clone $this;
        $self['percentage'] = $percentage;

        return $self;
    }

    /**
     * Red value of the color.
     */
    public function withRed(int $red): self
    {
        $self = clone $this;
        $self['red'] = $red;

        return $self;
    }

    /**
     * Green value of the color.
     */
    public function withGreen(int $green): self
    {
        $self = clone $this;
        $self['green'] = $green;

        return $self;
    }

    /**
     * Blue value of the color.
     */
    public function withBlue(int $blue): self
    {
        $self = clone $this;
        $self['blue'] = $blue;

        return $self;
    }
}
