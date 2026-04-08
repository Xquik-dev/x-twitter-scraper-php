<?php

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

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BookmarkGetFoldersResponse>
     *
     * @throws APIException
     */
    public function retrieveFolders(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/bookmarks/folders',
            options: $requestOptions,
            convert: BookmarkGetFoldersResponse::class,
        );
    }
}
