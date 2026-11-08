<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\BookmarksRawContract;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;
use XTwitterScraper\X\Bookmarks\BookmarkListParams;
use XTwitterScraper\X\Bookmarks\BookmarkRetrieveFoldersParams;

/**
 * Look up, search, and analyze individual tweets.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class BookmarksRawService implements BookmarksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get bookmarked tweets
     *
     * @param array{cursor?: string, folderID?: string}|BookmarkListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function list(
        array|BookmarkListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BookmarkListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/bookmarks',
            query: Util::array_transform_keys($parsed, ['folderID' => 'folderId']),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * Get bookmark folders
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
    ): BaseResponse {
        [$parsed, $options] = BookmarkRetrieveFoldersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/bookmarks/folders',
            query: $parsed,
            options: $options,
            convert: BookmarkGetFoldersResponse::class,
        );
    }
}
