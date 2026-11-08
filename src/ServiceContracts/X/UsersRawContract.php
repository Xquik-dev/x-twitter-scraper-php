<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\BatchUserTweets;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedLists;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ShadowbanReport;
use XTwitterScraper\UserLiveStatus;
use XTwitterScraper\UserProfile;
use XTwitterScraper\X\Users\UserBlockParams;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse;
use XTwitterScraper\X\Users\UserMuteParams;
use XTwitterScraper\X\Users\UserRemoveFollowerParams;
use XTwitterScraper\X\Users\UserRemoveFollowerResponse;
use XTwitterScraper\X\Users\UserRetrieveAffiliatesParams;
use XTwitterScraper\X\Users\UserRetrieveArticlesParams;
use XTwitterScraper\X\Users\UserRetrieveBatchParams;
use XTwitterScraper\X\Users\UserRetrieveBatchTweetsParams;
use XTwitterScraper\X\Users\UserRetrieveFollowerAuditParams;
use XTwitterScraper\X\Users\UserRetrieveFollowerAuditResponse;
use XTwitterScraper\X\Users\UserRetrieveFollowerIdsParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersYouKnowParams;
use XTwitterScraper\X\Users\UserRetrieveFollowingIdsParams;
use XTwitterScraper\X\Users\UserRetrieveFollowingParams;
use XTwitterScraper\X\Users\UserRetrieveHighlightsParams;
use XTwitterScraper\X\Users\UserRetrieveInsightsParams;
use XTwitterScraper\X\Users\UserRetrieveInsightsResponse;
use XTwitterScraper\X\Users\UserRetrieveLikesParams;
use XTwitterScraper\X\Users\UserRetrieveListMembershipsParams;
use XTwitterScraper\X\Users\UserRetrieveListsParams;
use XTwitterScraper\X\Users\UserRetrieveLiveParams;
use XTwitterScraper\X\Users\UserRetrieveMediaParams;
use XTwitterScraper\X\Users\UserRetrieveMentionsParams;
use XTwitterScraper\X\Users\UserRetrieveParams;
use XTwitterScraper\X\Users\UserRetrieveRepliesParams;
use XTwitterScraper\X\Users\UserRetrieveSearchParams;
use XTwitterScraper\X\Users\UserRetrieveShadowbanParams;
use XTwitterScraper\X\Users\UserRetrieveSimilarParams;
use XTwitterScraper\X\Users\UserRetrieveSubscriptionsParams;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams;
use XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams;
use XTwitterScraper\X\Users\UserTranslateBioParams;
use XTwitterScraper\X\Users\UserTranslateBioResponse;
use XTwitterScraper\X\Users\UserUnblockParams;
use XTwitterScraper\X\Users\UserUnmuteParams;
use XTwitterScraper\XWriteAction;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface UsersRawContract
{
    /**
     * @api
     *
     * @param string $id X username (without @) or user ID
     * @param array<string,mixed>|UserRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfile>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|UserRetrieveParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Path param: User ID to remove from your followers
     * @param array<string,mixed>|UserRemoveFollowerParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserRemoveFollowerResponse>
     *
     * @throws APIException
     */
    public function removeFollower(
        string $id,
        array|UserRemoveFollowerParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveBatchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetBatchResponse>
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
     * @param string $id target user ID or username for follower lookup
     * @param array<string,mixed>|UserRetrieveFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers|UserListCoverageResponse>
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
     * @return BaseResponse<PaginatedUsers|\XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse,>
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
     * @param string $id User ID or username
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
     * @param string $id User ID or username for media lookup
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
     * @param string $id target user ID or username for the replies timeline
     * @param array<string,mixed>|UserRetrieveRepliesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function retrieveReplies(
        string $id,
        array|UserRetrieveRepliesParams $params,
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
     * @return BaseResponse<PaginatedUsers|\XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse\UserListCoverageResponse,>
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        array|UserRetrieveVerifiedFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveBatchTweetsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BatchUserTweets>
     *
     * @throws APIException
     */
    public function retrieveBatchTweets(
        array|UserRetrieveBatchTweetsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserBlockParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XWriteAction>
     *
     * @throws APIException
     */
    public function block(
        string $id,
        array|UserBlockParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserUnblockParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XWriteAction>
     *
     * @throws APIException
     */
    public function unblock(
        string $id,
        array|UserUnblockParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserMuteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XWriteAction>
     *
     * @throws APIException
     */
    public function mute(
        string $id,
        array|UserMuteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserUnmuteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XWriteAction>
     *
     * @throws APIException
     */
    public function unmute(
        string $id,
        array|UserUnmuteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveAffiliatesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveAffiliates(
        string $id,
        array|UserRetrieveAffiliatesParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveSubscriptionsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveSubscriptions(
        string $id,
        array|UserRetrieveSubscriptionsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveListsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedLists>
     *
     * @throws APIException
     */
    public function retrieveLists(
        string $id,
        array|UserRetrieveListsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveListMembershipsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedLists>
     *
     * @throws APIException
     */
    public function retrieveListMemberships(
        string $id,
        array|UserRetrieveListMembershipsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveArticlesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets2>
     *
     * @throws APIException
     */
    public function retrieveArticles(
        string $id,
        array|UserRetrieveArticlesParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveHighlightsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets2>
     *
     * @throws APIException
     */
    public function retrieveHighlights(
        string $id,
        array|UserRetrieveHighlightsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveSimilarParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveSimilar(
        string $id,
        array|UserRetrieveSimilarParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserTranslateBioParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserTranslateBioResponse>
     *
     * @throws APIException
     */
    public function translateBio(
        string $id,
        array|UserTranslateBioParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveFollowerAuditParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserRetrieveFollowerAuditResponse>
     *
     * @throws APIException
     */
    public function retrieveFollowerAudit(
        string $id,
        array|UserRetrieveFollowerAuditParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveInsightsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserRetrieveInsightsResponse>
     *
     * @throws APIException
     */
    public function retrieveInsights(
        string $id,
        array|UserRetrieveInsightsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveLiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserLiveStatus>
     *
     * @throws APIException
     */
    public function retrieveLive(
        string $id,
        array|UserRetrieveLiveParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveShadowbanParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ShadowbanReport>
     *
     * @throws APIException
     */
    public function retrieveShadowban(
        string $id,
        array|UserRetrieveShadowbanParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveFollowerIdsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUserIDs>
     *
     * @throws APIException
     */
    public function retrieveFollowerIds(
        string $id,
        array|UserRetrieveFollowerIdsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|UserRetrieveFollowingIdsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUserIDs>
     *
     * @throws APIException
     */
    public function retrieveFollowingIds(
        string $id,
        array|UserRetrieveFollowingIdsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
