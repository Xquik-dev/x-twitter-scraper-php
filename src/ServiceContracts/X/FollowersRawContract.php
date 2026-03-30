<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Followers\FollowerCheckParams;
use XTwitterScraper\X\Followers\FollowerCheckResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface FollowersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|FollowerCheckParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowerCheckResponse>
     *
     * @throws APIException
     */
    public function check(
        array|FollowerCheckParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
