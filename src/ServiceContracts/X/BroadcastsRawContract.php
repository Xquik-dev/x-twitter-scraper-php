<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Broadcasts\BroadcastRetrieveParams;
use XTwitterScraper\X\Broadcasts\BroadcastRetrieveResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface BroadcastsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BroadcastRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BroadcastRetrieveResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|BroadcastRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
