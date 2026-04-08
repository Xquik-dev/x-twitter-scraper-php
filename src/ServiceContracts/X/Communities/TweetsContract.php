<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\Tweets\TweetListResponse;

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
     * @throws APIException
     */
    public function list(
        string $q,
        ?string $cursor = null,
        ?string $queryType = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetListResponse;
}
