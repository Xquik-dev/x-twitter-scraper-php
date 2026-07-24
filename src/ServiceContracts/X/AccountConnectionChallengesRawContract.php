<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitParams;
use XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountConnectionChallengesRawContract
{
    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param array<string,mixed>|AccountConnectionChallengeSubmitParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountConnectionChallengeSubmitResponse>
     *
     * @throws APIException
     */
    public function submit(
        string $id,
        array|AccountConnectionChallengeSubmitParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
