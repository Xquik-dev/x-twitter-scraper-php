<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Users;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
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
     * @param string $userID User ID to follow
     * @param array{account: string}|FollowCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $userID,
        array|FollowCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FollowCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/users/%1$s/follow', $userID],
            body: (object) $parsed,
            options: $options,
            convert: FollowNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Unfollow user
     *
     * @param string $userID User ID to unfollow
     * @param array{account: string}|FollowDeleteAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowDeleteAllResponse>
     *
     * @throws APIException
     */
    public function deleteAll(
        string $userID,
        array|FollowDeleteAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FollowDeleteAllParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/users/%1$s/follow', $userID],
            body: (object) $parsed,
            options: $options,
            convert: FollowDeleteAllResponse::class,
        );
    }
}
