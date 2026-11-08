<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder\Media;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder\Media\Palette\Rgb;

/**
 * @phpstan-type PaletteShape = array{
 *   percentage?: float|null,
 *   rgb?: Rgb|array<string,mixed>|null,
 * }
 */
final class Palette implements BaseModel
{
    /** @use SdkModel<PaletteShape> */
    use SdkModel;

    #[Optional]
    public ?float $percentage;

    #[Optional]
    public ?Rgb $rgb;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Rgb|array<string,mixed>|null $rgb
     */
    public static function with(?float $percentage = null, Rgb|array|null $rgb = null): self
    {
        $self = new self;

        null !== $percentage && $self['percentage'] = $percentage;
        null !== $rgb && $self['rgb'] = $rgb;

        return $self;
    }

    public function withPercentage(?float $percentage): self
    {
        $self = clone $this;
        $self['percentage'] = $percentage;

        return $self;
    }

    /**
     * @param Rgb|array<string,mixed>|null $rgb
     */
    public function withRgb(Rgb|array|null $rgb): self
    {
        $self = clone $this;
        $self['rgb'] = $rgb;

        return $self;
    }
}
