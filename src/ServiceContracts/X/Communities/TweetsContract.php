<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\CursorPage;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface TweetsContract
{
    /**
     * @api
     *
     * @param string $q Search query for cross-community tweets
     * @param string $cursor Pagination cursor for cross-community results
     * @param string $queryType Sort order for cross-community results (Latest or Top)
     * @param RequestOpts|null $requestOptions
     *
     * @return CursorPage<PaginatedTweets>
     *
     * @throws APIException
     */
    public function list(
        string $q,
        ?string $cursor = null,
        ?string $queryType = null,
        RequestOptions|array|null $requestOptions = null,
    ): CursorPage;

    /**
     * @api
     *
     * @param string $id Community ID for tweet lookup
     * @param string $cursor Pagination cursor for community tweets
     * @param RequestOpts|null $requestOptions
     *
     * @return CursorPage<PaginatedTweets>
     *
     * @throws APIException
     */
    public function listByCommunity(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): CursorPage;
}
