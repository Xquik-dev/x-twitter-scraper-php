<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Tweets;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Tweets\RetweetRawContract;
use XTwitterScraper\X\Tweets\Retweet\RetweetCreateParams;
use XTwitterScraper\X\Tweets\Retweet\RetweetDeleteParams;
use XTwitterScraper\X\Tweets\Retweet\RetweetDeleteResponse;
use XTwitterScraper\X\Tweets\Retweet\RetweetNewResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class RetweetRawService implements RetweetRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retweet
     *
     * @param string $id Path param: Tweet ID to retweet
     * @param array{
     *   account: string, idempotencyKey: string
     * }|RetweetCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RetweetNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|RetweetCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RetweetCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/tweets/%1$s/retweet', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: RetweetNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Unretweet
     *
     * @param string $id Path param: Tweet ID to unretweet
     * @param array{
     *   account: string, idempotencyKey: string
     * }|RetweetDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RetweetDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        array|RetweetDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RetweetDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/tweets/%1$s/retweet', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: RetweetDeleteResponse::class,
        );
    }
}
