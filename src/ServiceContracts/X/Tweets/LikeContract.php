<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Tweets;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Tweets\Like\LikeDeleteResponse;
use XTwitterScraper\X\Tweets\Like\LikeNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface LikeContract
{
    /**
     * @api
     *
     * @param string $id Tweet ID to like
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): LikeNewResponse;

    /**
     * @api
     *
     * @param string $id Tweet ID to unlike
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): LikeDeleteResponse;
}
