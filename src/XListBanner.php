<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\XListBanner\Palette;
use XTwitterScraper\XListBanner\SalientRect;

/**
 * @phpstan-type XListBannerShape = array{
 *   url: string,
 *   width?: int|null,
 *   height?: int|null,
 *   salientRect?: SalientRect|array<string,mixed>|null,
 *   mediaID?: string|null,
 *   mediaKey?: string|null,
 *   palette?: list<Palette|array<string,mixed>>|null,
 * }
 */
final class XListBanner implements BaseModel
{
    /** @use SdkModel<XListBannerShape> */
    use SdkModel;

    /**
     * Banner image URL.
     */
    #[Required]
    public string $url;

    /**
     * Banner width in pixels.
     */
    #[Optional]
    public ?int $width;

    /**
     * Banner height in pixels.
     */
    #[Optional]
    public ?int $height;

    /**
     * Area X marks as the subject of the banner, in pixels.
     */
    #[Optional]
    public ?SalientRect $salientRect;

    /**
     * Media ID of an uploaded banner.
     */
    #[Optional('mediaId')]
    public ?string $mediaID;

    /**
     * Stable media key of an uploaded banner.
     */
    #[Optional]
    public ?string $mediaKey;

    /**
     * Dominant colors of an uploaded banner and their shares.
     *
     * @var list<Palette>|null $palette
     */
    #[Optional(list: Palette::class)]
    public ?array $palette;

    /**
     * `new XListBanner()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XListBanner::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XListBanner)->withUrl(...)
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
     *
     * @param SalientRect|array<string,mixed>|null $salientRect
     * @param list<Palette|array<string,mixed>>|null $palette
     */
    public static function with(string $url, ?int $width = null, ?int $height = null, SalientRect|array|null $salientRect = null, ?string $mediaID = null, ?string $mediaKey = null, ?array $palette = null): self
    {
        $self = new self;

        $self['url'] = $url;

        null !== $width && $self['width'] = $width;
        null !== $height && $self['height'] = $height;
        null !== $salientRect && $self['salientRect'] = $salientRect;
        null !== $mediaID && $self['mediaID'] = $mediaID;
        null !== $mediaKey && $self['mediaKey'] = $mediaKey;
        null !== $palette && $self['palette'] = $palette;

        return $self;
    }

    /**
     * Banner image URL.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Banner width in pixels.
     */
    public function withWidth(?int $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }

    /**
     * Banner height in pixels.
     */
    public function withHeight(?int $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }

    /**
     * Area X marks as the subject of the banner, in pixels.
     *
     * @param SalientRect|array<string,mixed>|null $salientRect
     */
    public function withSalientRect(SalientRect|array|null $salientRect): self
    {
        $self = clone $this;
        $self['salientRect'] = $salientRect;

        return $self;
    }

    /**
     * Media ID of an uploaded banner.
     */
    public function withMediaID(?string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * Stable media key of an uploaded banner.
     */
    public function withMediaKey(?string $mediaKey): self
    {
        $self = clone $this;
        $self['mediaKey'] = $mediaKey;

        return $self;
    }

    /**
     * Dominant colors of an uploaded banner and their shares.
     *
     * @param list<Palette|array<string,mixed>>|null $palette
     */
    public function withPalette(?array $palette): self
    {
        $self = clone $this;
        $self['palette'] = $palette;

        return $self;
    }
}
