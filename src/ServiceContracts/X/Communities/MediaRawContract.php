<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\Media\MediaListParams;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface MediaRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|MediaListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets2>
     *
     * @throws APIException
     */
    public function list(
        string $id,
        array|MediaListParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
