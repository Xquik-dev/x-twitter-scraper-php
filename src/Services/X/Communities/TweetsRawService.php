<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Communities;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Communities\TweetsRawContract;
use XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams;
use XTwitterScraper\X\Communities\Tweets\TweetListParams;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\QueryType;

/**
 * X Community info, members, and tweets.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TweetsRawService implements TweetsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Requires a Community ID and keyword query.
     *
     * @param array{
     *   communityID: string,
     *   q: string,
     *   cursor?: string,
     *   pageSize?: int,
     *   queryType?: QueryType|value-of<QueryType>,
     * }|TweetListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function list(
        array|TweetListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/communities/tweets',
            query: Util::array_transform_keys(
                $parsed,
                ['communityID' => 'communityId']
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * List tweets posted in a community
     *
     * @param string $id Community ID for tweet lookup
     * @param array{cursor?: string, pageSize?: int}|TweetListByCommunityParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function listByCommunity(
        string $id,
        array|TweetListByCommunityParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TweetListByCommunityParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/communities/%1$s/tweets', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedTweets::class,
        );
    }
}
