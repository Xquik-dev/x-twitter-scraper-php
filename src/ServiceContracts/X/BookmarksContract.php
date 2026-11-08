<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
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
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        ?string $folderID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFolders(
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null
    ): BookmarkGetFoldersResponse;
}
