<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Accounts\AccountBulkRetryResponse;
use XTwitterScraper\X\Accounts\AccountDeleteResponse;
use XTwitterScraper\X\Accounts\AccountListResponse;
use XTwitterScraper\X\Accounts\AccountNewResponse\SanitizedXAccount;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionChallenge;
use XTwitterScraper\X\Accounts\AccountReauthResponse;
use XTwitterScraper\X\Accounts\XAccountDetail;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface AccountsContract
{
    /**
     * @api
     *
     * @param string $email Account email
     * @param string $password Account password
     * @param string $totpSecret Authenticator App TOTP secret required for durable login
     * @param string $username X username
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $email,
        string $password,
        string $totpSecret,
        string $username,
        RequestOptions|array|null $requestOptions = null,
    ): SanitizedXAccount|XAccountConnectionAttemptPending|XAccountConnectionChallenge;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): XAccountDetail;

    /**
     * @api
     *
     * @param int|null $limit Maximum items per page, from 1 to 10,000. Default 50. A low credit balance can return fewer paid results. When it covers none, the answer is 402 insufficient_credits.
     * @param string|null $cursor Previous nextCursor. The after alias also works. Offset pagination is not supported.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null
    ): AccountListResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): AccountDeleteResponse;

    /**
     * @api
     *
     * @param list<mixed>|null $accountIDs IDs of the X accounts to retry. Accounts that failed for another reason, or belong to someone else, stay as they are.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function bulkRetry(
        ?array $accountIDs = null,
        RequestOptions|array|null $requestOptions = null
    ): AccountBulkRetryResponse;

    /**
     * @api
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param string $password Updated account password
     * @param string $email Email for the X account (updates stored email)
     * @param string $totpSecret Replacement Authenticator App TOTP secret. Omit it to reuse the saved secret.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function reauth(
        string $id,
        string $password,
        ?string $email = null,
        ?string $totpSecret = null,
        RequestOptions|array|null $requestOptions = null,
    ): AccountReauthResponse;
}
