<?php

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
     * Create a one-use Stripe-hosted checkout after the user explicitly confirms a $10-$250 USD amount. This request creates no charge by itself. The user opens checkout_url on Stripe. This endpoint returns the paid-read API key without requiring an Xquik account, email, dashboard, or Xquik web page. An idempotent replay returns the same key.
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
     * Poll after Stripe payment. Use usable to decide whether paid reads can run. An active wallet can remain usable while a top-up is pending. A new wallet becomes usable only after verified webhook fulfillment. Send the guest key as Authorization: Bearer.
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
     * Create a one-use Stripe-hosted checkout for an existing paid-read guest key after the user explicitly confirms a $10-$250 USD amount. The key remains the same. This request creates no charge by itself and never redirects through an Xquik web page.
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
