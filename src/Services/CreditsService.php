<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\CreditsContract;

/**
 * Subscription & billing.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class CreditsService implements CreditsContract
{
    /**
     * @api
     */
    public CreditsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CreditsRawService($client);
    }

    /**
     * @api
     *
     * Get credits balance
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveBalance(
        RequestOptions|array|null $requestOptions = null
    ): CreditGetBalanceResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveBalance(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Top up credits balance
     *
     * @param int $amount Amount to top up in credits
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function topupBalance(
        int $amount,
        RequestOptions|array|null $requestOptions = null
    ): CreditTopupBalanceResponse {
        $params = Util::removeNulls(['amount' => $amount]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->topupBalance(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
