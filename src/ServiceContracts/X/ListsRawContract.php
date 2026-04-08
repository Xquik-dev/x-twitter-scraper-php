<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Lists\ListGetFollowersResponse;
use XTwitterScraper\X\Lists\ListGetMembersResponse;
use XTwitterScraper\X\Lists\ListGetTweetsResponse;
use XTwitterScraper\X\Lists\ListRetrieveFollowersParams;
use XTwitterScraper\X\Lists\ListRetrieveMembersParams;
use XTwitterScraper\X\Lists\ListRetrieveTweetsParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ListsRawContract
{
    /**
     * @api
     *
     * @param string $id List ID
     * @param array<string,mixed>|ListRetrieveFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListGetFollowersResponse>
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        array|ListRetrieveFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id List ID for member lookup
     * @param array<string,mixed>|ListRetrieveMembersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListGetMembersResponse>
     *
     * @throws APIException
     */
    public function retrieveMembers(
        string $id,
        array|ListRetrieveMembersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id List ID for tweet lookup
     * @param array<string,mixed>|ListRetrieveTweetsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ListGetTweetsResponse>
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        array|ListRetrieveTweetsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
