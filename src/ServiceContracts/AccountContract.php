<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Account\AccountGetResponse;
use XTwitterScraper\Account\AccountSetXUsernameResponse;
use XTwitterScraper\Account\AccountUpdateLocaleParams\Locale;
use XTwitterScraper\Account\AccountUpdateLocaleResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): AccountGetResponse;

    /**
     * @api
     *
     * @param string $username X username without @
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function setXUsername(
        string $username,
        RequestOptions|array|null $requestOptions = null
    ): AccountSetXUsernameResponse;

    /**
     * @api
     *
     * @param Locale|value-of<Locale> $locale
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateLocale(
        Locale|string $locale,
        RequestOptions|array|null $requestOptions = null
    ): AccountUpdateLocaleResponse;
}
