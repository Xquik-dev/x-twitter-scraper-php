<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\CommunityDeleteResponse;
use XTwitterScraper\X\Communities\CommunityGetInfoResponse;
use XTwitterScraper\X\Communities\CommunityNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface CommunitiesContract
{
    /**
     * @api
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
    ): CommunityNewResponse;

    /**
     * @api
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
    ): CommunityDeleteResponse;

    /**
     * @api
     *
     * @param string $id Community ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveInfo(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): CommunityGetInfoResponse;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedUsers;

    /**
     * @api
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
    ): PaginatedTweets;
}
