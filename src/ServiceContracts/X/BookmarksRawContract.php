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
     * @param RequestOpts|null $requestOptions
     * @param array<string,mixed>|BookmarkRetrieveFoldersParams $params
     *
     * @return BaseResponse<BookmarkGetFoldersResponse>
     *
     * @throws APIException
     */
    public function retrieveFolders(
        RequestOptions|array|null $requestOptions = null,
        array|BookmarkRetrieveFoldersParams $params = []
    ): BaseResponse;
}
