<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder\Media\Palette;

/**
 * @phpstan-type MediaShape = array{
 *   id?: string|null,
 *   mediaID?: string|null,
 *   mediaKey?: string|null,
 *   originalImageHeight?: int|null,
 *   originalImageUrl?: string|null,
 *   originalImageWidth?: int|null,
 *   palette?: list<Palette|array<string,mixed>>|null,
 *   type?: string|null,
 * }
 */
final class Media implements BaseModel
{
    /** @use SdkModel<MediaShape> */
    use SdkModel;

    /**
     * Media object ID.
     */
    #[Optional]
    public ?string $id;

    /**
     * Media ID.
     */
    #[Optional('mediaId')]
    public ?string $mediaID;

    /**
     * Stable media key.
     */
    #[Optional]
    public ?string $mediaKey;

    /**
     * Original image height.
     */
    #[Optional]
    public ?int $originalImageHeight;

    /**
     * Original image URL.
     */
    #[Optional]
    public ?string $originalImageUrl;

    /**
     * Original image width.
     */
    #[Optional]
    public ?int $originalImageWidth;

    /**
     * Dominant image colors and their proportions.
     *
     * @var list<Palette>|null $palette
     */
    #[Optional(list: Palette::class)]
    public ?array $palette;

    /**
     * Media object type.
     */
    #[Optional]
    public ?string $type;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Palette|array<string,mixed>>|null $palette
     */
    public static function with(?string $id = null, ?string $mediaID = null, ?string $mediaKey = null, ?int $originalImageHeight = null, ?string $originalImageUrl = null, ?int $originalImageWidth = null, ?array $palette = null, ?string $type = null): self
    {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $mediaID && $self['mediaID'] = $mediaID;
        null !== $mediaKey && $self['mediaKey'] = $mediaKey;
        null !== $originalImageHeight && $self['originalImageHeight'] = $originalImageHeight;
        null !== $originalImageUrl && $self['originalImageUrl'] = $originalImageUrl;
        null !== $originalImageWidth && $self['originalImageWidth'] = $originalImageWidth;
        null !== $palette && $self['palette'] = $palette;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Media object ID.
     */
    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Media ID.
     */
    public function withMediaID(?string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * Stable media key.
     */
    public function withMediaKey(?string $mediaKey): self
    {
        $self = clone $this;
        $self['mediaKey'] = $mediaKey;

        return $self;
    }

    /**
     * Original image height.
     */
    public function withOriginalImageHeight(?int $originalImageHeight): self
    {
        $self = clone $this;
        $self['originalImageHeight'] = $originalImageHeight;

        return $self;
    }

    /**
     * Original image URL.
     */
    public function withOriginalImageUrl(?string $originalImageUrl): self
    {
        $self = clone $this;
        $self['originalImageUrl'] = $originalImageUrl;

        return $self;
    }

    /**
     * Original image width.
     */
    public function withOriginalImageWidth(?int $originalImageWidth): self
    {
        $self = clone $this;
        $self['originalImageWidth'] = $originalImageWidth;

        return $self;
    }

    /**
     * Dominant image colors and their proportions.
     *
     * @param list<Palette|array<string,mixed>>|null $palette
     */
    public function withPalette(?array $palette): self
    {
        $self = clone $this;
        $self['palette'] = $palette;

        return $self;
    }

    /**
     * Media object type.
     */
    public function withType(?string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
