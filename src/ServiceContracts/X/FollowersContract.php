<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

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
     * @param string $source Source username, @username, or X or Twitter profile URL
     * @param string $target Target username, @username, or X or Twitter profile URL
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
