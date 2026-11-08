<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\CommunityBanner;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FocusShape = array{
 *   left?: int|null,
 *   top?: int|null,
 *   width?: int|null,
 *   height?: int|null,
 * }
 */
final class Focus implements BaseModel
{
    /** @use SdkModel<FocusShape> */
    use SdkModel;

    /**
     * Distance from the left edge.
     */
    #[Optional]
    public ?int $left;

    /**
     * Distance from the top edge.
     */
    #[Optional]
    public ?int $top;

    /**
     * Width of the area.
     */
    #[Optional]
    public ?int $width;

    /**
     * Height of the area.
     */
    #[Optional]
    public ?int $height;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $left = null, ?int $top = null, ?int $width = null, ?int $height = null): self
    {
        $self = new self;

        null !== $left && $self['left'] = $left;
        null !== $top && $self['top'] = $top;
        null !== $width && $self['width'] = $width;
        null !== $height && $self['height'] = $height;

        return $self;
    }

    /**
     * Distance from the left edge.
     */
    public function withLeft(?int $left): self
    {
        $self = clone $this;
        $self['left'] = $left;

        return $self;
    }

    /**
     * Distance from the top edge.
     */
    public function withTop(?int $top): self
    {
        $self = clone $this;
        $self['top'] = $top;

        return $self;
    }

    /**
     * Width of the area.
     */
    public function withWidth(?int $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }

    /**
     * Height of the area.
     */
    public function withHeight(?int $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }
}
