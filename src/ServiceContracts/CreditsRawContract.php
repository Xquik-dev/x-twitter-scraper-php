<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditTopupBalanceParams;
use XTwitterScraper\Credits\CreditTopupBalanceResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface CreditsRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreditGetBalanceResponse>
     *
     * @throws APIException
     */
    public function retrieveBalance(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|CreditTopupBalanceParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreditTopupBalanceResponse>
     *
     * @throws APIException
     */
    public function topupBalance(
        array|CreditTopupBalanceParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
