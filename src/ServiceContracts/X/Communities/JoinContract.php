<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\Join\JoinDeleteAllResponse;
use XTwitterScraper\X\Communities\Join\JoinNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface JoinContract
{
    /**
     * @api
     *
     * @param string $id path param: Resource ID returned by the matching create or list endpoint
     * @param string $account Body param: X account identifier (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $id,
        string $account,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): JoinNewResponse;

    /**
     * @api
     *
     * @param string $id path param: Resource ID returned by the matching create or list endpoint
     * @param string $account Body param: X account identifier (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function deleteAll(
        string $id,
        string $account,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): JoinDeleteAllResponse;
}
