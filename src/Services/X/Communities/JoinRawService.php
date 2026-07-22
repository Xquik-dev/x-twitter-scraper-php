<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Communities;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
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
     * @param string $id path param: Resource ID returned by the matching create or list endpoint
     * @param array{account: string, idempotencyKey: string}|JoinCreateParams $params
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/communities/%1$s/join', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: JoinNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Leave community
     *
     * @param string $id path param: Resource ID returned by the matching create or list endpoint
     * @param array{
     *   account: string, idempotencyKey: string
     * }|JoinDeleteAllParams $params
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
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/communities/%1$s/join', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: JoinDeleteAllResponse::class,
        );
    }
}
