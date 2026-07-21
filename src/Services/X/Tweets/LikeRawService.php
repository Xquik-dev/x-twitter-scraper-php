<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Tweets;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Tweets\LikeRawContract;
use XTwitterScraper\X\Tweets\Like\LikeCreateParams;
use XTwitterScraper\X\Tweets\Like\LikeDeleteParams;
use XTwitterScraper\X\Tweets\Like\LikeDeleteResponse;
use XTwitterScraper\X\Tweets\Like\LikeNewResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class LikeRawService implements LikeRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Like tweet
     *
     * @param string $id Path param: Tweet ID to like
     * @param array{account: string, idempotencyKey: string}|LikeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LikeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|LikeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = LikeCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/tweets/%1$s/like', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: LikeNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Unlike tweet
     *
     * @param string $id Path param: Tweet ID to unlike
     * @param array{account: string, idempotencyKey: string}|LikeDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LikeDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|LikeDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = LikeDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/tweets/%1$s/like', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: LikeDeleteResponse::class,
        );
    }
}
