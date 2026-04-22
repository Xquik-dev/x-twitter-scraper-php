<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Users\UserProfile;
use XTwitterScraper\X\Users\UserRetrieveBatchParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersYouKnowParams;
use XTwitterScraper\X\Users\UserRetrieveFollowingParams;
use XTwitterScraper\X\Users\UserRetrieveLikesParams;
use XTwitterScraper\X\Users\UserRetrieveMediaParams;
use XTwitterScraper\X\Users\UserRetrieveMentionsParams;
use XTwitterScraper\X\Users\UserRetrieveSearchParams;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams;
use XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface UsersRawContract
{
    /**
     * @api
     *
     * @param string $id X username (without @) or user ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfile>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveBatchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveBatch(
        array|UserRetrieveBatchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID or username
     * @param array<string,mixed>|UserRetrieveFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        array|UserRetrieveFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID for followers-you-know lookup
     * @param array<string,mixed>|UserRetrieveFollowersYouKnowParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveFollowersYouKnow(
        string $id,
        array|UserRetrieveFollowersYouKnowParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID or username for following lookup
     * @param array<string,mixed>|UserRetrieveFollowingParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        array|UserRetrieveFollowingParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID
     * @param array<string,mixed>|UserRetrieveLikesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveLikes(
        string $id,
        array|UserRetrieveLikesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID for media lookup
     * @param array<string,mixed>|UserRetrieveMediaParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveMedia(
        string $id,
        array|UserRetrieveMediaParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID or username for mentions lookup
     * @param array<string,mixed>|UserRetrieveMentionsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveMentions(
        string $id,
        array|UserRetrieveMentionsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveSearch(
        array|UserRetrieveSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id X user ID or username
     * @param array<string,mixed>|UserRetrieveTweetsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        array|UserRetrieveTweetsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id User ID or username for verified followers
     * @param array<string,mixed>|UserRetrieveVerifiedFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        array|UserRetrieveVerifiedFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
