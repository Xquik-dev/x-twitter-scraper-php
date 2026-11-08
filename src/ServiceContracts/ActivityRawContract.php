<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Activity\ActivityListParams;
use XTwitterScraper\ActivityLogRow;
use XTwitterScraper\ActivityRecord;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface ActivityRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ActivityListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<list<ActivityLogRow>>
     *
     * @throws APIException
     */
    public function list(
        array|ActivityListParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ActivityRecord>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
