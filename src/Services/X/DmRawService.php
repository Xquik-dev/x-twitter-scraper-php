<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\DmRawContract;
use XTwitterScraper\X\Dm\DmGetHistoryResponse;
use XTwitterScraper\X\Dm\DmRetrieveHistoryParams;
use XTwitterScraper\X\Dm\DmSendParams;
use XTwitterScraper\X\Dm\DmSendResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param array{cursor?: string, maxID?: string}|DmRetrieveHistoryParams $params
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
     * @param string $userID Recipient user ID
     * @param array{
     *   account: string,
     *   text: string,
     *   mediaIDs?: list<string>,
     *   replyToMessageID?: string,
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/dm/%1$s', $userID],
            body: (object) $parsed,
            options: $options,
            convert: DmSendResponse::class,
        );
    }
}
