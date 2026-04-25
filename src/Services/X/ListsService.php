<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\ListsContract;

/**
 * X List followers, members, and tweets.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ListsService implements ListsContract
{
    /**
     * @api
     */
    public ListsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ListsRawService($client);
    }

    /**
     * @api
     *
     * List followers of an X List
     *
     * @param string $id List ID
     * @param string $cursor Pagination cursor for list followers
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List members of an X List
     *
     * @param string $id List ID for member lookup
     * @param string $cursor Pagination cursor for list members
     * @param int $pageSize Members per page (20-200, default 20)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        ?string $cursor = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMembers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets from an X List
     *
     * @param string $id List ID for tweet lookup
     * @param string $cursor Pagination cursor for list tweets
     * @param bool $includeReplies Include replies (default false)
     * @param string $sinceTime Unix timestamp - filter after
     * @param string $untilTime Unix timestamp - filter before
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        ?string $cursor = null,
        ?bool $includeReplies = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'includeReplies' => $includeReplies,
                'sinceTime' => $sinceTime,
                'untilTime' => $untilTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTweets($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
