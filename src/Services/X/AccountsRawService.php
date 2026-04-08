<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountsRawContract;
use XTwitterScraper\X\Accounts\AccountBulkRetryResponse;
use XTwitterScraper\X\Accounts\AccountCreateParams;
use XTwitterScraper\X\Accounts\AccountDeleteResponse;
use XTwitterScraper\X\Accounts\AccountListResponse;
use XTwitterScraper\X\Accounts\AccountNewResponse;
use XTwitterScraper\X\Accounts\AccountReauthParams;
use XTwitterScraper\X\Accounts\AccountReauthResponse;
use XTwitterScraper\X\Accounts\XAccountDetail;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountsRawService implements AccountsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Connect X account
     *
     * @param array{
     *   email: string,
     *   password: string,
     *   username: string,
     *   proxyCountry?: string,
     *   totpSecret?: string,
     * }|AccountCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AccountCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AccountCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/accounts',
            body: (object) $parsed,
            options: $options,
            convert: AccountNewResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * Get X account details
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XAccountDetail>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/accounts/%1$s', $id],
            options: $requestOptions,
            convert: XAccountDetail::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * List connected X accounts
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/accounts',
            options: $requestOptions,
            convert: AccountListResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * Disconnect X account
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/accounts/%1$s', $id],
            options: $requestOptions,
            convert: AccountDeleteResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * Clears loginFailedAt and loginFailureReason for all accounts with transient or automated failure reasons, making them eligible for retry on next use.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountBulkRetryResponse>
     *
     * @throws APIException
     */
    public function bulkRetry(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/accounts/bulk-retry',
            options: $requestOptions,
            convert: AccountBulkRetryResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * Re-authenticate X account
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{password: string, totpSecret?: string}|AccountReauthParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountReauthResponse>
     *
     * @throws APIException
     */
    public function reauth(
        string $id,
        array|AccountReauthParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AccountReauthParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/accounts/%1$s/reauth', $id],
            body: (object) $parsed,
            options: $options,
            convert: AccountReauthResponse::class,
            security: ['apiKey' => true],
        );
    }
}
