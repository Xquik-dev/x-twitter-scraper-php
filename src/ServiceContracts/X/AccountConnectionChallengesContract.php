<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\AccountConnectionChallenges\AccountConnectionChallengeSubmitResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountConnectionChallengesContract
{
    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param string $emailCode code sent to the account email
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submit(
        string $id,
        string $emailCode,
        RequestOptions|array|null $requestOptions = null,
    ): AccountConnectionChallengeSubmitResponse;
}
