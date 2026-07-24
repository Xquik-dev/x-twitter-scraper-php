<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;
use XTwitterScraper\GuestWallets\GuestWalletNewResponse;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface GuestWalletsContract
{
    /**
     * @api
     *
     * @param int $amountMinor body param: USD cents accepted for this checkout
     * @param string $idempotencyKey Header param: Generate a cryptographically random UUID v4. Reuse it only to retry the same wallet and amount request. Initial wallet creation can recover the API key from this value, so store it as a secret and never log it.
     * @param 'usd' $currency Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        int $amountMinor,
        string $idempotencyKey,
        string $currency = 'usd',
        RequestOptions|array|null $requestOptions = null,
    ): GuestWalletNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveStatus(
        RequestOptions|array|null $requestOptions = null
    ): GuestWalletGetStatusResponse;

    /**
     * @api
     *
     * @param int $amountMinor body param: USD cents accepted for this checkout
     * @param string $idempotencyKey Header param: Generate a cryptographically random UUID v4. Reuse it only to retry the same wallet and amount request. Initial wallet creation can recover the API key from this value, so store it as a secret and never log it.
     * @param 'usd' $currency Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function topup(
        int $amountMinor,
        string $idempotencyKey,
        string $currency = 'usd',
        RequestOptions|array|null $requestOptions = null,
    ): GuestWalletTopupResponse;
}
