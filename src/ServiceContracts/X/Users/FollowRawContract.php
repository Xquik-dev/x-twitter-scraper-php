<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Users;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Users\Follow\FollowCreateParams;
use XTwitterScraper\X\Users\Follow\FollowDeleteAllParams;
use XTwitterScraper\X\Users\Follow\FollowDeleteAllResponse;
use XTwitterScraper\X\Users\Follow\FollowNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface FollowRawContract
{
    /**
     * @api
     *
     * @param string $id User ID to follow
     * @param array<string,mixed>|FollowCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|FollowCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID to unfollow
     * @param array<string,mixed>|FollowDeleteAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowDeleteAllResponse>
     *
     * @throws APIException
     */
    public function deleteAll(
        string $id,
        array|FollowDeleteAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
