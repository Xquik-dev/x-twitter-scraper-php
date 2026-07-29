<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Accounts\AccountBulkRetryResponse;
use XTwitterScraper\X\Accounts\AccountDeleteResponse;
use XTwitterScraper\X\Accounts\AccountListResponse;
use XTwitterScraper\X\Accounts\AccountReauthResponse;
use XTwitterScraper\X\Accounts\XAccountDetail;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
    ): mixed;

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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function bulkRetry(
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
