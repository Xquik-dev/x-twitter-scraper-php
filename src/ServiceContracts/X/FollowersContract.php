<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Followers\FollowerCheckResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface FollowersContract
{
    /**
     * @api
     *
     * @param string $source Username to check (without @)
     * @param string $target Target username (without @)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function check(
        string $source,
        string $target,
        RequestOptions|array|null $requestOptions = null,
    ): FollowerCheckResponse;
}
