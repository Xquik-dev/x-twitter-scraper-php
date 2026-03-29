<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Tweets;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse;
use XTwitterScraper\X\Tweets\Retweet\RetweetNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface RetweetContract
{
    /**
     * @api
     *
     * @param string $account X account (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $tweetID,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): RetweetNewResponse;

    /**
     * @api
     *
     * @param string $account X account (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $tweetID,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): RetweetDeleteResponse;
}
