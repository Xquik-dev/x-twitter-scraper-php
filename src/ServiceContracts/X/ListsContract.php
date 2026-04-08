<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Lists\ListGetFollowersResponse;
use XTwitterScraper\X\Lists\ListGetMembersResponse;
use XTwitterScraper\X\Lists\ListGetTweetsResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ListsContract
{
    /**
     * @api
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
    ): ListGetFollowersResponse;

    /**
     * @api
     *
     * @param string $id List ID for member lookup
     * @param string $cursor Pagination cursor for list members
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): ListGetMembersResponse;

    /**
     * @api
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
    ): ListGetTweetsResponse;
}
