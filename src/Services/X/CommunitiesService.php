<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\CommunitiesContract;
use XTwitterScraper\Services\X\Communities\JoinService;
use XTwitterScraper\Services\X\Communities\TweetsService;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\QueryType;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class CommunitiesService implements CommunitiesContract
{
    /**
     * @api
     */
    public CommunitiesRawService $raw;

    /**
     * @api
     */
    public JoinService $join;

    /**
     * @api
     */
    public TweetsService $tweets;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CommunitiesRawService($client);
        $this->join = new JoinService($client);
        $this->tweets = new TweetsService($client);
    }

    /**
     * @api
     *
     * Create community
     *
     * @param string $account X account (@username or ID) creating the community
     * @param string $name Community name
     * @param string $description Community description
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $account,
        string $name,
        ?string $description = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityNewResponse {
        $params = Util::removeNulls(
            ['account' => $account, 'name' => $name, 'description' => $description]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete community
     *
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param string $account X account (@username or ID) deleting the community
     * @param string $communityName Community name for confirmation
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $account,
        string $communityName,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityDeleteResponse {
        $params = Util::removeNulls(
            ['account' => $account, 'communityName' => $communityName]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get community name, description and member count
     *
     * @param string $id Community ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveInfo(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): CommunityGetInfoResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveInfo($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List members of a community
     *
     * @param string $id Community ID for member lookup
     * @param string $cursor Pagination cursor
     * @param int $pageSize Items per page (20-200, default 20). This is an upper bound for paid authenticated calls: remaining credits can reduce the returned page size, and zero affordable results returns 402 insufficient_credits.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        ?string $cursor = null,
        int $pageSize = 20,
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
     * List moderators of a community
     *
     * @param string $id Community ID for moderator lookup
     * @param string $cursor Pagination cursor for community moderators
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveModerators(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveModerators($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns tweets, not community records. Requires a Community ID.
     *
     * @param string $communityID Numeric ID of the community whose posts to search
     * @param string $q Search query
     * @param string $cursor Pagination cursor for community search
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param QueryType|value-of<QueryType> $queryType Sort order (Latest or Top)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
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
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
