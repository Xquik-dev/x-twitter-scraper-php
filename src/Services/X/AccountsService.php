<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountsContract;
use XTwitterScraper\X\Accounts\AccountDeleteResponse;
use XTwitterScraper\X\Accounts\AccountGetResponse;
use XTwitterScraper\X\Accounts\AccountListResponse;
use XTwitterScraper\X\Accounts\AccountNewResponse;
use XTwitterScraper\X\Accounts\AccountReauthResponse;

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
     * @param string $username X username
     * @param string $proxyCountry Proxy country code
     * @param string $totpSecret TOTP secret for 2FA
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $email,
        string $password,
        string $username,
        ?string $proxyCountry = null,
        ?string $totpSecret = null,
        RequestOptions|array|null $requestOptions = null,
    ): AccountNewResponse {
        $params = Util::removeNulls(
            [
                'email' => $email,
                'password' => $password,
                'username' => $username,
                'proxyCountry' => $proxyCountry,
                'totpSecret' => $totpSecret,
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
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): AccountGetResponse {
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
     * @param string $id Resource ID (stringified bigint)
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
     * Re-authenticate X account
     *
     * @param string $id Resource ID (stringified bigint)
     * @param string $password Account password
     * @param string $totpSecret TOTP secret for 2FA
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function reauth(
        string $id,
        string $password,
        ?string $totpSecret = null,
        RequestOptions|array|null $requestOptions = null,
    ): AccountReauthResponse {
        $params = Util::removeNulls(
            ['password' => $password, 'totpSecret' => $totpSecret]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->reauth($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
