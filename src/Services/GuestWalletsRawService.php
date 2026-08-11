<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\GuestWallets\GuestWalletCreateParams;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;
use XTwitterScraper\GuestWallets\GuestWalletNewResponse;
use XTwitterScraper\GuestWallets\GuestWalletTopupParams;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\GuestWalletsRawContract;

/**
 * Accountless prepaid access for paid read endpoints.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class GuestWalletsRawService implements GuestWalletsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a one-use hosted checkout after the user confirms $10-$250 USD. The request creates no charge. It returns a paid-read API key without an Xquik account. Replays return the same key.
     *
     * @param array{
     *   amountMinor: int, currency?: 'usd', idempotencyKey: string
     * }|GuestWalletCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GuestWalletNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|GuestWalletCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = GuestWalletCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'guest-wallets',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: GuestWalletNewResponse::class,
            security: [],
        );
    }

    /**
     * @api
     *
     * Poll after payment. Use usable to decide whether paid reads can run. An active wallet can remain usable while a top-up is pending. A new wallet becomes usable only after payment is verified. Send the guest key as Authorization: Bearer.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GuestWalletGetStatusResponse>
     *
     * @throws APIException
     */
    public function retrieveStatus(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'guest-wallets/status',
            options: $requestOptions,
            convert: GuestWalletGetStatusResponse::class,
            security: ['apiKey' => true],
        );
    }

    /**
     * @api
     *
     * Create a one-use hosted checkout after the user confirms a $10-$250 USD amount for an existing paid-read guest key. The key remains the same. This request creates no charge and never redirects through Xquik.
     *
     * @param array{
     *   amountMinor: int, currency?: 'usd', idempotencyKey: string
     * }|GuestWalletTopupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GuestWalletTopupResponse>
     *
     * @throws APIException
     */
    public function topup(
        array|GuestWalletTopupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = GuestWalletTopupParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'guest-wallets/topups',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: GuestWalletTopupResponse::class,
            security: ['apiKey' => true],
        );
    }
}
