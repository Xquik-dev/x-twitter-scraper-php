<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Communities;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Communities\JoinRawContract;
use XTwitterScraper\X\Communities\Join\JoinCreateParams;
use XTwitterScraper\X\Communities\Join\JoinDeleteAllParams;
use XTwitterScraper\X\Communities\Join\JoinDeleteAllResponse;
use XTwitterScraper\X\Communities\Join\JoinNewResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class JoinRawService implements JoinRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Join community
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{account: string}|JoinCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<JoinNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|JoinCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = JoinCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/communities/%1$s/join', $id],
            body: (object) $parsed,
            options: $options,
            convert: JoinNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Leave community
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array{account: string}|JoinDeleteAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<JoinDeleteAllResponse>
     *
     * @throws APIException
     */
    public function deleteAll(
        string $id,
        array|JoinDeleteAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = JoinDeleteAllParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/communities/%1$s/join', $id],
            body: (object) $parsed,
            options: $options,
            convert: JoinDeleteAllResponse::class,
        );
    }
}
