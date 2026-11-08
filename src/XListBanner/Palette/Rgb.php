<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\XListBanner\Palette;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RgbShape = array{
 *   red?: int|null,
 *   green?: int|null,
 *   blue?: int|null,
 * }
 */
final class Rgb implements BaseModel
{
    /** @use SdkModel<RgbShape> */
    use SdkModel;

    #[Optional]
    public ?int $red;

    #[Optional]
    public ?int $green;

    #[Optional]
    public ?int $blue;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $red = null, ?int $green = null, ?int $blue = null): self
    {
        $self = new self;

        null !== $red && $self['red'] = $red;
        null !== $green && $self['green'] = $green;
        null !== $blue && $self['blue'] = $blue;

        return $self;
    }

    public function withRed(?int $red): self
    {
        $self = clone $this;
        $self['red'] = $red;

        return $self;
    }

    public function withGreen(?int $green): self
    {
        $self = clone $this;
        $self['green'] = $green;

        return $self;
    }

    public function withBlue(?int $blue): self
    {
        $self = clone $this;
        $self['blue'] = $blue;

        return $self;
    }
}
