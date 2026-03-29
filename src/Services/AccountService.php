<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Account\AccountGetResponse;
use XTwitterScraper\Account\AccountSetXUsernameResponse;
use XTwitterScraper\Account\AccountUpdateLocaleParams\Locale;
use XTwitterScraper\Account\AccountUpdateLocaleResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\AccountContract;

/**
 * Account info & settings.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountService implements AccountContract
{
    /**
     * @api
     */
    public AccountRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AccountRawService($client);
    }

    /**
     * @api
     *
     * Get account info
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): AccountGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Set linked X username
     *
     * @param string $username X username without @
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function setXUsername(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): AccountSetXUsernameResponse {
        $params = Util::removeNulls(['username' => $username]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->setXUsername(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update account locale
     *
     * @param Locale|value-of<Locale> $locale
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateLocale(
        Locale|string $locale,
        RequestOptions|array|null $requestOptions = null
    ): AccountUpdateLocaleResponse {
        $params = Util::removeNulls(['locale' => $locale]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateLocale(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
