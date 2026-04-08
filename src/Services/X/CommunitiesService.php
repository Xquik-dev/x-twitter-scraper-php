<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\CommunitiesContract;
use XTwitterScraper\Services\X\Communities\JoinService;
use XTwitterScraper\Services\X\Communities\TweetsService;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityGetMembersResponse;
use XTwitterScraper\X\Communities\CommunityGetModeratorsResponse;
use XTwitterScraper\X\Communities\CommunityGetSearchResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;

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
     * @param string $id Resource ID (stringified bigint)
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
     * Get community details
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
     * Get community members
     *
     * @param string $id Community ID for member lookup
     * @param string $cursor Pagination cursor
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityGetMembersResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMembers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get community moderators
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
    ): CommunityGetModeratorsResponse {
        $params = Util::removeNulls(['cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveModerators($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search tweets across communities
     *
     * @param string $q Search query
     * @param string $cursor Pagination cursor for community search
     * @param string $queryType Sort order (Latest or Top)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $q,
        ?string $cursor = null,
        ?string $queryType = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityGetSearchResponse {
        $params = Util::removeNulls(
            ['q' => $q, 'cursor' => $cursor, 'queryType' => $queryType]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
