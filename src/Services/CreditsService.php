<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\CreditsContract;

/**
 * Subscription, billing, and credits.
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
     * Redirect to an active top-up payment page
     *
     * @param string $sessionID billing session ID returned by the top-up billing flow
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function redirectTopupCheckout(
        string $sessionID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        $params = Util::removeNulls(['sessionID' => $sessionID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->redirectTopupCheckout(params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * Get top-up billing status
     *
     * @param string $sessionID top-up session ID to inspect
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTopupStatus(
        string $sessionID,
        RequestOptions|array|null $requestOptions = null
    ): CreditGetTopupStatusResponse {
        $params = Util::removeNulls(['sessionID' => $sessionID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTopupStatus(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Create a Stripe Checkout session only after the user confirms. The request never completes payment or adds credits by itself.
     *
     * @param int $dollars Amount to top up in US dollars. Minimum 10.
     * @param string $locale Optional checkout locale. Defaults to en.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function topupBalance(
        int $dollars,
        ?string $locale = null,
        RequestOptions|array|null $requestOptions = null,
    ): CreditTopupBalanceResponse {
        $params = Util::removeNulls(['dollars' => $dollars, 'locale' => $locale]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->topupBalance(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
