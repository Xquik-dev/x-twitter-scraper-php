<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountsContract;
use XTwitterScraper\X\Accounts\AccountBulkRetryResponse;
use XTwitterScraper\X\Accounts\AccountDeleteResponse;
use XTwitterScraper\X\Accounts\AccountListResponse;
use XTwitterScraper\X\Accounts\AccountNewResponse\SanitizedXAccount;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionAttemptPending;
use XTwitterScraper\X\Accounts\AccountNewResponse\XAccountConnectionChallenge;
use XTwitterScraper\X\Accounts\AccountReauthResponse;
use XTwitterScraper\X\Accounts\XAccountDetail;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountsService implements AccountsContract
{
    /**
     * @api
     */
    public AccountsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AccountsRawService($client);
    }

    /**
     * @api
     *
     * Connect X account
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
    ): SanitizedXAccount|XAccountConnectionAttemptPending|XAccountConnectionChallenge {
        $params = Util::removeNulls(
            [
                'email' => $email,
                'password' => $password,
                'totpSecret' => $totpSecret,
                'username' => $username,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get X account details
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): XAccountDetail {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List connected X accounts
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): AccountListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Disconnect X account
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): AccountDeleteResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Clears loginFailedAt and loginFailureReason for all accounts with transient or automated failure reasons, making them eligible for retry on next use.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function bulkRetry(
        RequestOptions|array|null $requestOptions = null
    ): AccountBulkRetryResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->bulkRetry(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Re-authenticate X account
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
    ): AccountReauthResponse {
        $params = Util::removeNulls(
            ['password' => $password, 'email' => $email, 'totpSecret' => $totpSecret]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->reauth($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
