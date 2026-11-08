<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder\Media\Palette;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RgbShape = array{
 *   blue?: float|null,
 *   green?: float|null,
 *   red?: float|null,
 * }
 */
final class Rgb implements BaseModel
{
    /** @use SdkModel<RgbShape> */
    use SdkModel;

    #[Optional]
    public ?float $blue;

    #[Optional]
    public ?float $green;

    #[Optional]
    public ?float $red;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?float $blue = null, ?float $green = null, ?float $red = null): self
    {
        $self = new self;

        null !== $blue && $self['blue'] = $blue;
        null !== $green && $self['green'] = $green;
        null !== $red && $self['red'] = $red;

        return $self;
    }

    public function withBlue(?float $blue): self
    {
        $self = clone $this;
        $self['blue'] = $blue;

        return $self;
    }

    public function withGreen(?float $green): self
    {
        $self = clone $this;
        $self['green'] = $green;

        return $self;
    }

    public function withRed(?float $red): self
    {
        $self = clone $this;
        $self['red'] = $red;

        return $self;
    }
}
