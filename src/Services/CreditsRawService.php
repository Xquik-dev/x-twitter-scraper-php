<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditTopupBalanceParams;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\CreditsRawContract;

/**
 * Subscription & billing.
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
     * Top up credits balance
     *
     * @param array{amount: int}|CreditTopupBalanceParams $params
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
