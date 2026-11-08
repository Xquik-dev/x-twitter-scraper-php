<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\CommunityBanner\Colors;
use XTwitterScraper\CommunityBanner\Focus;
use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityBannerShape = array{
 *   url: string,
 *   width?: int|null,
 *   height?: int|null,
 *   colors?: list<Colors|array<string,mixed>>|null,
 *   focus?: Focus|array<string,mixed>|null,
 * }
 */
final class CommunityBanner implements BaseModel
{
    /** @use SdkModel<CommunityBannerShape> */
    use SdkModel;

    /**
     * Banner image URL at its original size.
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
     * Main colors of the banner, largest share first.
     *
     * @var list<Colors>|null $colors
     */
    #[Optional(list: Colors::class)]
    public ?array $colors;

    /**
     * Area X keeps in view when it crops the banner, in pixels from the top left.
     */
    #[Optional]
    public ?Focus $focus;

    /**
     * `new CommunityBanner()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityBanner::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityBanner)->withUrl(...)
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
     * @param list<Colors|array<string,mixed>>|null $colors
     * @param Focus|array<string,mixed>|null $focus
     */
    public static function with(string $url, ?int $width = null, ?int $height = null, ?array $colors = null, Focus|array|null $focus = null): self
    {
        $self = new self;

        $self['url'] = $url;

        null !== $width && $self['width'] = $width;
        null !== $height && $self['height'] = $height;
        null !== $colors && $self['colors'] = $colors;
        null !== $focus && $self['focus'] = $focus;

        return $self;
    }

    /**
     * Banner image URL at its original size.
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
     * Main colors of the banner, largest share first.
     *
     * @param list<Colors|array<string,mixed>>|null $colors
     */
    public function withColors(?array $colors): self
    {
        $self = clone $this;
        $self['colors'] = $colors;

        return $self;
    }

    /**
     * Area X keeps in view when it crops the banner, in pixels from the top left.
     *
     * @param Focus|array<string,mixed>|null $focus
     */
    public function withFocus(Focus|array|null $focus): self
    {
        $self = clone $this;
        $self['focus'] = $focus;

        return $self;
    }
}
