<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function topupBalance(
        int $dollars,
        ?string $locale = null,
        RequestOptions|array|null $requestOptions = null,
    ): CreditTopupBalanceResponse;
}
