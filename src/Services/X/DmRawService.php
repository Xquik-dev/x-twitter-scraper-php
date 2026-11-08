<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\DmRawContract;
use XTwitterScraper\X\Dm\DmDeleteMessageParams;
use XTwitterScraper\X\Dm\DmGetHistoryResponse;
use XTwitterScraper\X\Dm\DmRetrieveHistoryParams;
use XTwitterScraper\X\Dm\DmSendParams;
use XTwitterScraper\X\Dm\DmSendResponse;
use XTwitterScraper\XWriteAction;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class DmRawService implements DmRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get DM conversation history
     *
     * @param string $userID Target user ID
     * @param array{
     *   account: string, cursor?: string, maxID?: string
     * }|DmRetrieveHistoryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DmGetHistoryResponse>
     *
     * @throws APIException
     */
    public function retrieveHistory(
        string $userID,
        array|DmRetrieveHistoryParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DmRetrieveHistoryParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/dm/%1$s/history', $userID],
            query: Util::array_transform_keys($parsed, ['maxID' => 'maxId']),
            options: $options,
            convert: DmGetHistoryResponse::class,
        );
    }

    /**
     * @api
     *
     * Send direct message
     *
     * @param string $userID Path param: Recipient user ID
     * @param array{
     *   account: string, text: string, idempotencyKey: string, mediaIDs?: list<string>
     * }|DmSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DmSendResponse>
     *
     * @throws APIException
     */
    public function send(
        string $userID,
        array|DmSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DmSendParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/dm/%1$s', $userID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: DmSendResponse::class,
        );
    }

    /**
     * @api
     *
     * Deletes 1 DM from the account's side. The other person keeps it. Success means the DM is gone from the account's conversation. A DM that stays gets 422 `x_dm_not_deleted`, and Xquik charges nothing.
     *
     * @param array<string,mixed>|DmDeleteMessageParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XWriteAction>
     *
     * @throws APIException
     */
    public function deleteMessage(
        string $userID,
        string $messageID,
        array|DmDeleteMessageParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DmDeleteMessageParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/dm/%1$s/messages/%2$s', $userID, $messageID],
            query: $parsed,
            options: $options,
            convert: XWriteAction::class,
        );
    }
}
