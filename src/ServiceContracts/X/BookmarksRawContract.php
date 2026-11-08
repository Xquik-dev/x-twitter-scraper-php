<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;
use XTwitterScraper\X\Bookmarks\BookmarkListParams;
use XTwitterScraper\X\Bookmarks\BookmarkRetrieveFoldersParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface BookmarksRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BookmarkListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function list(
        array|BookmarkListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|BookmarkRetrieveFoldersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BookmarkGetFoldersResponse>
     *
     * @throws APIException
     */
    public function retrieveFolders(
        array|BookmarkRetrieveFoldersParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
