<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Media\MediaDownloadResponse\Items;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type QualitiesShape = array{
 *   bitrate: int,
 *   height: int,
 *   url: string,
 *   width: int,
 * }
 */
final class Qualities implements BaseModel
{
    /** @use SdkModel<QualitiesShape> */
    use SdkModel;

    #[Required]
    public int $bitrate;

    #[Required]
    public int $height;

    #[Required]
    public string $url;

    #[Required]
    public int $width;

    /**
     * `new Qualities()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Qualities::with(bitrate: ..., height: ..., url: ..., width: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Qualities)->withBitrate(...)->withHeight(...)->withUrl(...)->withWidth(...)
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
    public static function with(int $bitrate, int $height, string $url, int $width): self
    {
        $self = new self;

        $self['bitrate'] = $bitrate;
        $self['height'] = $height;
        $self['url'] = $url;
        $self['width'] = $width;

        return $self;
    }

    public function withBitrate(int $bitrate): self
    {
        $self = clone $this;
        $self['bitrate'] = $bitrate;

        return $self;
    }

    public function withHeight(int $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }

    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withWidth(int $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }
}
