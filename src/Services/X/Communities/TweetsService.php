<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Communities;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Communities\TweetsContract;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\QueryType;

/**
 * X Community info, members, and tweets.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TweetsService implements TweetsContract
{
    /**
     * @api
     */
    public TweetsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TweetsRawService($client);
    }

    /**
     * @api
     *
     * Requires a Community ID and keyword query.
     *
     * @param string $communityID Numeric ID of the community to search
     * @param string $q Keyword query within the selected community
     * @param string $cursor Pagination cursor for community results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param QueryType|value-of<QueryType> $queryType Sort order for community results (Latest or Top)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $communityID,
        string $q,
        ?string $cursor = null,
        int $pageSize = 20,
        QueryType|string $queryType = 'Latest',
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'communityID' => $communityID,
                'q' => $q,
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'queryType' => $queryType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets posted in a community
     *
     * @param string $id Community ID for tweet lookup
     * @param string $cursor Pagination cursor for community tweets
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listByCommunity(
        string $id,
        ?string $cursor = null,
        int $pageSize = 20,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listByCommunity($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
