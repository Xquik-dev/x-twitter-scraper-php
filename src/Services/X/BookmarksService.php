<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\BookmarksContract;
use XTwitterScraper\X\Bookmarks\BookmarkGetFoldersResponse;
use XTwitterScraper\X\Bookmarks\BookmarkListResponse;

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
    ): BookmarkListResponse {
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFolders(
        RequestOptions|array|null $requestOptions = null
    ): BookmarkGetFoldersResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFolders(requestOptions: $requestOptions);

        return $response->parse();
    }
}
