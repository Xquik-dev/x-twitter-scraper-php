<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse;
use XTwitterScraper\Credits\CreditRedirectTopupCheckoutParams;
use XTwitterScraper\Credits\CreditRetrieveTopupStatusParams;
use XTwitterScraper\Credits\CreditTopupBalanceParams;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\CreditsRawContract;

/**
 * Subscription, billing, and credits.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class CreditsRawService implements CreditsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Redirect to an active top-up payment page
     *
     * @param array{sessionID: string}|CreditRedirectTopupCheckoutParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function redirectTopupCheckout(
        array|CreditRedirectTopupCheckoutParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CreditRedirectTopupCheckoutParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'credits/topup/redirect',
            query: Util::array_transform_keys($parsed, ['sessionID' => 'session_id']),
            options: $options,
            convert: null,
            security: [],
        );
    }

    /**
     * @api
     *
     * Get credits balance
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreditGetBalanceResponse>
     *
     * @throws APIException
     */
    public function retrieveBalance(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'credits',
            options: $requestOptions,
            convert: CreditGetBalanceResponse::class,
        );
    }

    /**
     * @api
     *
     * Get top-up billing status
     *
     * @param array{sessionID: string}|CreditRetrieveTopupStatusParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreditGetTopupStatusResponse>
     *
     * @throws APIException
     */
    public function retrieveTopupStatus(
        array|CreditRetrieveTopupStatusParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CreditRetrieveTopupStatusParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'credits/topup/status',
            query: Util::array_transform_keys($parsed, ['sessionID' => 'session_id']),
            options: $options,
            convert: CreditGetTopupStatusResponse::class,
        );
    }

    /**
     * @api
     *
     * Create a hosted checkout only after the user confirms. The request never completes payment or adds credits.
     *
     * @param array{dollars: int, locale?: string}|CreditTopupBalanceParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreditTopupBalanceResponse>
     *
     * @throws APIException
     */
    public function topupBalance(
        array|CreditTopupBalanceParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CreditTopupBalanceParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'credits/topup',
            body: (object) $parsed,
            options: $options,
            convert: CreditTopupBalanceResponse::class,
        );
    }
}
