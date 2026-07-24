<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Credits\CreditGetBalanceResponse;
use XTwitterScraper\Credits\CreditGetTopupStatusResponse;
use XTwitterScraper\Credits\CreditRedirectTopupCheckoutParams;
use XTwitterScraper\Credits\CreditRetrieveTopupStatusParams;
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
     * @param array<string,mixed>|CreditRedirectTopupCheckoutParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function redirectTopupCheckout(
        array|CreditRedirectTopupCheckoutParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

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
     * @param array<string,mixed>|CreditRetrieveTopupStatusParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CreditGetTopupStatusResponse>
     *
     * @throws APIException
     */
    public function retrieveTopupStatus(
        array|CreditRetrieveTopupStatusParams $params,
        RequestOptions|array|null $requestOptions = null,
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
