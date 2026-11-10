<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkCreateParams;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkDeleteResponse;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkNewResponse;
use XTwitterScraper\X\AccountConnectionLinks\XAccountConnectionLink;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountConnectionLinksRawContract
{
    /**
     * @api
     *
     * @param array{
     *   accountID?: string, reference?: string, returnURL?: string
     * }|AccountConnectionLinkCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountConnectionLinkNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AccountConnectionLinkCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id connect link ID returned when you created the link
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XAccountConnectionLink>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id connect link ID returned when you created the link
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountConnectionLinkDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
