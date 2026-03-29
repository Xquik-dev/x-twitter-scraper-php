<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Tweets;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
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
     * @param array{account: string}|LikeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LikeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $tweetID,
        array|LikeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = LikeCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/tweets/%1$s/like', $tweetID],
            body: (object) $parsed,
            options: $options,
            convert: LikeNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Unlike tweet
     *
     * @param array{account: string}|LikeDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<LikeDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $tweetID,
        array|LikeDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = LikeDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/tweets/%1$s/like', $tweetID],
            body: (object) $parsed,
            options: $options,
            convert: LikeDeleteResponse::class,
        );
    }
}
