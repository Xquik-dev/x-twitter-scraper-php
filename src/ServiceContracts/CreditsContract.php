<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;
use XTwitterScraper\Currency;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface CreditsContract
{
    /**
     * @api
     *
     * @param string $sessionID billing session ID returned by the top-up billing flow
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function redirectTopupCheckout(
        string $sessionID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveBalance(
        RequestOptions|array|null $requestOptions = null
    ): CreditGetBalanceResponse;

    /**
     * @api
     *
     * @param string $sessionID top-up session ID to inspect
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTopupStatus(
        string $sessionID,
        RequestOptions|array|null $requestOptions = null
    ): CreditGetTopupStatusResponse;

    /**
     * @api
     *
     * @param int $dollars Amount to top up in US dollars. Minimum 10.
     * @param string $locale Optional checkout locale. Defaults to en.
     * @param Currency|value-of<Currency>|null $currency Currency to pay in. Xquik converts the dollar amount at the latest daily ECB rate. If the newest rates are more than 3 ECB working days old, it charges USD instead, and Checkout shows that before payment. `chargedCurrency` shows the currency charged. Credits always match the dollar amount. Lowercase codes work too.
     * @param string|null $returnPath optional Xquik tool page to return to after Checkout, such as /en/x-article-reader
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function topupBalance(
        int $dollars,
        ?string $locale = null,
        Currency|string|null $currency = null,
        ?string $returnPath = null,
        RequestOptions|array|null $requestOptions = null,
    ): CreditTopupBalanceResponse;
}
