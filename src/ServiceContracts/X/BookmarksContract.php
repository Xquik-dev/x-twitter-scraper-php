<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\CursorPage;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface BookmarksContract
{
    /**
     * @api
     *
     * @param string $cursor Pagination cursor for bookmarks
     * @param string $folderID Optional bookmark folder ID
     * @param RequestOpts|null $requestOptions
     *
     * @return CursorPage<PaginatedTweets>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        ?string $folderID = null,
        RequestOptions|array|null $requestOptions = null,
    ): CursorPage;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFolders(
        RequestOptions|array|null $requestOptions = null
    ): BookmarkGetFoldersResponse;
}
