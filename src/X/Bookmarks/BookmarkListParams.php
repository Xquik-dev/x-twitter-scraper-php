<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Bookmarks;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get bookmarked tweets.
 *
 * @see XTwitterScraper\Services\X\BookmarksService::list()
 *
 * @phpstan-type BookmarkListParamsShape = array{
 *   cursor?: string|null, folderID?: string|null
 * }
 */
final class BookmarkListParams implements BaseModel
{
    /** @use SdkModel<BookmarkListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor from previous response.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Optional bookmark folder ID.
     */
    #[Optional]
    public ?string $folderID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $cursor = null,
        ?string $folderID = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $folderID && $self['folderID'] = $folderID;

        return $self;
    }

    /**
     * Pagination cursor from previous response.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Optional bookmark folder ID.
     */
    public function withFolderID(string $folderID): self
    {
        $self = clone $this;
        $self['folderID'] = $folderID;

        return $self;
    }
}
