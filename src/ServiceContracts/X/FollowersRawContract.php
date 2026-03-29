<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Followers\FollowerGetCheckResponse;
use XTwitterScraper\X\Followers\FollowerRetrieveCheckParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface FollowersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|FollowerRetrieveCheckParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowerGetCheckResponse>
     *
     * @throws APIException
     */
    public function retrieveCheck(
        array|FollowerRetrieveCheckParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
