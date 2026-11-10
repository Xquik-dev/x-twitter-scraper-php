<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\AccountConnectionLinksRawContract;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkCreateParams;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkDeleteResponse;
use XTwitterScraper\X\AccountConnectionLinks\AccountConnectionLinkNewResponse;
use XTwitterScraper\X\AccountConnectionLinks\XAccountConnectionLink;

/**
 * Connected X account management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class AccountConnectionLinksRawService implements AccountConnectionLinksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create X account connect link
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
    ): BaseResponse {
        [$parsed, $options] = AccountConnectionLinkCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'x/account-connection-links',
            body: (object) $parsed,
            options: $options,
            convert: AccountConnectionLinkNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get X account connect link
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/account-connection-links/%1$s', $id],
            options: $requestOptions,
            convert: XAccountConnectionLink::class,
        );
    }

    /**
     * @api
     *
     * Revoke X account connect link
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/account-connection-links/%1$s', $id],
            options: $requestOptions,
            convert: AccountConnectionLinkDeleteResponse::class,
        );
    }
}
