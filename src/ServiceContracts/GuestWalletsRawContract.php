<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\GuestWallets\GuestWalletCreateParams;
use XTwitterScraper\GuestWallets\GuestWalletGetStatusResponse;
use XTwitterScraper\GuestWallets\GuestWalletNewResponse;
use XTwitterScraper\GuestWallets\GuestWalletTopupParams;
use XTwitterScraper\GuestWallets\GuestWalletTopupResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface GuestWalletsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|GuestWalletCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GuestWalletNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|GuestWalletCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GuestWalletGetStatusResponse>
     *
     * @throws APIException
     */
    public function retrieveStatus(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|GuestWalletTopupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<GuestWalletTopupResponse>
     *
     * @throws APIException
     */
    public function topup(
        array|GuestWalletTopupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
