<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Account\AccountGetResponse;
use XTwitterScraper\Account\AccountSetXUsernameParams;
use XTwitterScraper\Account\AccountSetXUsernameResponse;
use XTwitterScraper\Account\AccountUpdateLocaleParams;
use XTwitterScraper\Account\AccountUpdateLocaleParams\Locale;
use XTwitterScraper\Account\AccountUpdateLocaleResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\AccountRawContract;

/**
 * Account info & settings.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountRawService implements AccountRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get account info
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'account',
            options: $requestOptions,
            convert: AccountGetResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * Set linked X username
     *
     * @param array{username: string}|AccountSetXUsernameParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountSetXUsernameResponse>
     *
     * @throws APIException
     */
    public function setXUsername(
        array|AccountSetXUsernameParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AccountSetXUsernameParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'put',
            path: 'account/x-identity',
            body: (object) $parsed,
            options: $options,
            convert: AccountSetXUsernameResponse::class,
        );
    }

    /**
     * @api
     *
     * Update account locale
     *
     * @param array{locale: Locale|value-of<Locale>}|AccountUpdateLocaleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountUpdateLocaleResponse>
     *
     * @throws APIException
     */
    public function updateLocale(
        array|AccountUpdateLocaleParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AccountUpdateLocaleParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: 'account',
            body: (object) $parsed,
            options: $options,
            convert: AccountUpdateLocaleResponse::class,
            security: [],
        );
    }
}
