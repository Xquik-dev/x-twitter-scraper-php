<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Users;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Users\FollowRawContract;
use XTwitterScraper\X\Users\Follow\FollowCreateParams;
use XTwitterScraper\X\Users\Follow\FollowDeleteAllParams;
use XTwitterScraper\X\Users\Follow\FollowDeleteAllResponse;
use XTwitterScraper\X\Users\Follow\FollowNewResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class FollowRawService implements FollowRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Follow user
     *
     * @param string $id Path param: User ID to follow
     * @param array{account: string, idempotencyKey: string}|FollowCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|FollowCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FollowCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/users/%1$s/follow', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: FollowNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Unfollow user
     *
     * @param string $id Path param: User ID to unfollow
     * @param array{
     *   account: string, idempotencyKey: string
     * }|FollowDeleteAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowDeleteAllResponse>
     *
     * @throws APIException
     */
    public function deleteAll(
        string $id,
        array|FollowDeleteAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FollowDeleteAllParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/users/%1$s/follow', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: FollowDeleteAllResponse::class,
        );
    }
}
