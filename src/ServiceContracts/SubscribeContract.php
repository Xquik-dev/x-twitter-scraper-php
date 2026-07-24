<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Subscribe\SubscribeCreateParams\Tier;
use XTwitterScraper\Subscribe\SubscribeNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface SubscribeContract
{
    /**
     * @api
     *
     * @param Tier|value-of<Tier> $tier subscription tier to pre-select
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        Tier|string|null $tier = null,
        RequestOptions|array|null $requestOptions = null
    ): SubscribeNewResponse;
}
