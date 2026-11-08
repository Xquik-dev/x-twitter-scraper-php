<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder\Media;

/**
 * @phpstan-type FolderShape = array{id: string, name: string,
 *   media?: Media|array<string,mixed>|null,
 * }
 */
final class Folder implements BaseModel
{
    /** @use SdkModel<FolderShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $name;

    /**
     * Public folder cover image metadata.
     */
    #[Optional]
    public ?Media $media;

    /**
     * `new Folder()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Folder::with(id: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Folder)->withID(...)->withName(...)
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
     * @param Media|array<string,mixed>|null $media
     */
    public static function with(string $id, string $name, Media|array|null $media = null): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['name'] = $name;

        null !== $media && $self['media'] = $media;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Public folder cover image metadata.
     *
     * @param Media|array<string,mixed>|null $media
     */
    public function withMedia(Media|array|null $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }
}
