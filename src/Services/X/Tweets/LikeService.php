<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Tweets;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Tweets\LikeContract;
use XTwitterScraper\X\Tweets\Like\LikeDeleteResponse;
use XTwitterScraper\X\Tweets\Like\LikeNewResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class LikeService implements LikeContract
{
    /**
     * @api
     */
    public LikeRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new LikeRawService($client);
    }

    /**
     * @api
     *
     * Like tweet
     *
     * @param string $id Tweet ID to like
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): LikeNewResponse {
        $params = Util::removeNulls(['account' => $account]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Unlike tweet
     *
     * @param string $id Tweet ID to unlike
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): LikeDeleteResponse {
        $params = Util::removeNulls(['account' => $account]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
