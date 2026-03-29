<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Bookmarks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder;

/**
 * @phpstan-import-type FolderShape from \XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse\Folder
 *
 * @phpstan-type BookmarkGetFoldersResponseShape = array{
 *   folders: list<Folder|FolderShape>, hasNextPage: bool, nextCursor: string
 * }
 */
final class BookmarkGetFoldersResponse implements BaseModel
{
    /** @use SdkModel<BookmarkGetFoldersResponseShape> */
    use SdkModel;

    /** @var list<Folder> $folders */
    #[Required(list: Folder::class)]
    public array $folders;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * `new BookmarkGetFoldersResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BookmarkGetFoldersResponse::with(
     *   folders: ..., hasNextPage: ..., nextCursor: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BookmarkGetFoldersResponse)
     *   ->withFolders(...)
     *   ->withHasNextPage(...)
     *   ->withNextCursor(...)
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
     * @param list<Folder|FolderShape> $folders
     */
    public static function with(
        array $folders,
        bool $hasNextPage,
        string $nextCursor
    ): self {
        $self = new self;

        $self['folders'] = $folders;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<Folder|FolderShape> $folders
     */
    public function withFolders(array $folders): self
    {
        $self = clone $this;
        $self['folders'] = $folders;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }
}
