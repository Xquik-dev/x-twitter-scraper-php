<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\FollowersRawContract;
use XTwitterScraper\X\Followers\FollowerCheckParams;
use XTwitterScraper\X\Followers\FollowerCheckResponse;

/**
 * X data lookups (subscription required).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class FollowersRawService implements FollowersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Check follow relationship
     *
     * @param array{source: string, target: string}|FollowerCheckParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FollowerCheckResponse>
     *
     * @throws APIException
     */
    public function check(
        array|FollowerCheckParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FollowerCheckParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/followers/check',
            query: $parsed,
            options: $options,
            convert: FollowerCheckResponse::class,
        );
    }
}
