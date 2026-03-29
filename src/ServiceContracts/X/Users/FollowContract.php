<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Users;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Users\Follow\FollowDeleteAllResponse;
use XTwitterScraper\X\Users\Follow\FollowNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface FollowContract
{
    /**
     * @api
     *
     * @param string $userID User ID to follow
     * @param string $account X account (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $userID,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): FollowNewResponse;

    /**
     * @api
     *
     * @param string $userID User ID to unfollow
     * @param string $account X account (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deleteAll(
        string $userID,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): FollowDeleteAllResponse;
}
