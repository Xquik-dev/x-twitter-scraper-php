<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\BookmarksContract;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;

/**
 * Look up, search, and analyze individual tweets.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class BookmarksService implements BookmarksContract
{
    /**
     * @api
     */
    public BookmarksRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BookmarksRawService($client);
    }

    /**
     * @api
     *
     * Get bookmarked tweets
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
    ): PaginatedTweets {
        $params = Util::removeNulls(['cursor' => $cursor, 'folderID' => $folderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get bookmark folders
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFolders(
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null
    ): BookmarkGetFoldersResponse {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFolders(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
