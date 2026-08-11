<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;
use XTwitterScraper\GuestWallets\GuestWalletNewResponse;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\GuestWalletsContract;

/**
 * Accountless prepaid access for paid read endpoints.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class GuestWalletsService implements GuestWalletsContract
{
    /**
     * @api
     */
    public GuestWalletsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new GuestWalletsRawService($client);
    }

    /**
     * @api
     *
     * Create a one-use hosted checkout after the user confirms $10-$250 USD. The request creates no charge. It returns a paid-read API key without an Xquik account. Idempotent replays return the same key.
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
    ): GuestWalletNewResponse {
        $params = Util::removeNulls(
            [
                'amountMinor' => $amountMinor,
                'currency' => $currency,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Poll after payment. Use usable to decide whether paid reads can run. An active wallet can remain usable while a top-up is pending. A new wallet becomes usable only after payment is verified. Send the guest key as Authorization: Bearer.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveStatus(
        RequestOptions|array|null $requestOptions = null
    ): GuestWalletGetStatusResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveStatus(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Create a one-use hosted checkout after the user confirms a $10-$250 USD amount for an existing paid-read guest key. The key remains the same. This request creates no charge and never redirects through Xquik.
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
    ): GuestWalletTopupResponse {
        $params = Util::removeNulls(
            [
                'amountMinor' => $amountMinor,
                'currency' => $currency,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->topup(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
