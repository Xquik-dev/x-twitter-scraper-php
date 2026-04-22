<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Tweets;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
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
     * @param string $id Tweet ID to retweet
     * @param array{account: string}|RetweetCreateParams $params
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/tweets/%1$s/retweet', $id],
            body: (object) $parsed,
            options: $options,
            convert: RetweetNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Unretweet
     *
     * @param string $id Tweet ID to unretweet
     * @param array{account: string}|RetweetDeleteParams $params
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

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/tweets/%1$s/retweet', $id],
            body: (object) $parsed,
            options: $options,
            convert: RetweetDeleteResponse::class,
        );
    }
}
