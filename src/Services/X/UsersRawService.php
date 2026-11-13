<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\BatchUserTweets;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedLists;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedTweets2;
use XTwitterScraper\PaginatedUserIDs;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\UsersRawContract;
use XTwitterScraper\ShadowbanReport;
use XTwitterScraper\UserLiveStatus;
use XTwitterScraper\UserProfile;
use XTwitterScraper\X\Users\UserBlockParams;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse;
use XTwitterScraper\X\Users\UserGetFollowingResponse;
use XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse;
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
use XTwitterScraper\X\Users\UserRetrieveFollowersParams\Mode;
use XTwitterScraper\X\Users\UserRetrieveFollowersYouKnowParams;
use XTwitterScraper\X\Users\UserRetrieveFollowingIdsParams;
use XTwitterScraper\X\Users\UserRetrieveFollowingParams;
use XTwitterScraper\X\Users\UserRetrieveHighlightsParams;
use XTwitterScraper\X\Users\UserRetrieveInsightsParams;
use XTwitterScraper\X\Users\UserRetrieveInsightsResponse;
use XTwitterScraper\X\Users\UserRetrieveLikesParams;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\MediaType;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Quotes;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Replies;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Retweets;
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
final class UsersRawService implements UsersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get user profile with follower counts and verification
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s', $id],
            query: $parsed,
            options: $options,
            convert: UserProfile::class,
        );
    }

    /**
     * @api
     *
     * Remove follower
     *
     * @param string $id Path param: User ID to remove from your followers
     * @param array{
     *   account: string, idempotencyKey: string
     * }|UserRemoveFollowerParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRemoveFollowerParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['idempotencyKey' => 'Idempotency-Key'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/users/%1$s/remove-follower', $id],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: $options,
            convert: UserRemoveFollowerResponse::class,
        );
    }

    /**
     * @api
     *
     * Look up multiple users by IDs in one call
     *
     * @param array{ids: string}|UserRetrieveBatchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserGetBatchResponse>
     *
     * @throws APIException
     */
    public function retrieveBatch(
        array|UserRetrieveBatchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveBatchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/users/batch',
            query: $parsed,
            options: $options,
            convert: UserGetBatchResponse::class,
        );
    }

    /**
     * @api
     *
     * List followers of a user
     *
     * @param string $id target user ID or username for follower lookup
     * @param array{
     *   after?: string,
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   limit?: int,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   mode?: Mode|value-of<Mode>,
     *   pageSize?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|UserRetrieveFollowersParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/followers', $id],
            query: $parsed,
            options: $options,
            convert: UserGetFollowersResponse::class,
        );
    }

    /**
     * @api
     *
     * List mutual followers between you and a user
     *
     * @param string $id User ID for followers-you-know lookup
     * @param array{
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   pageSize?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|UserRetrieveFollowersYouKnowParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowersYouKnowParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/followers-you-know', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * List accounts a user follows
     *
     * @param string $id User ID or username for following lookup
     * @param array{
     *   after?: string,
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   limit?: int,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   mode?: UserRetrieveFollowingParams\Mode|value-of<UserRetrieveFollowingParams\Mode>,
     *   pageSize?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|UserRetrieveFollowingParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers|UserGetFollowingResponse\UserListCoverageResponse,>
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        array|UserRetrieveFollowingParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowingParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/following', $id],
            query: $parsed,
            options: $options,
            convert: UserGetFollowingResponse::class,
        );
    }

    /**
     * @api
     *
     * List tweets liked by a user
     *
     * @param string $id User ID or username
     * @param array{
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: MediaType|value-of<MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   pageSize?: int,
     *   quotes?: Quotes|value-of<Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: Replies|value-of<Replies>,
     *   retweets?: Retweets|value-of<Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   source?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
     * }|UserRetrieveLikesParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveLikesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/likes', $id],
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * List media tweets posted by a user
     *
     * @param string $id User ID or username for media lookup
     * @param array{
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   imageShows?: string,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: UserRetrieveMediaParams\MediaType|value-of<UserRetrieveMediaParams\MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   pageSize?: int,
     *   quotes?: UserRetrieveMediaParams\Quotes|value-of<UserRetrieveMediaParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: UserRetrieveMediaParams\Replies|value-of<UserRetrieveMediaParams\Replies>,
     *   retweets?: UserRetrieveMediaParams\Retweets|value-of<UserRetrieveMediaParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   source?: string,
     *   topic?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
     * }|UserRetrieveMediaParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveMediaParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/media', $id],
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * List tweets mentioning a user
     *
     * @param string $id User ID or username for mentions lookup
     * @param array{
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: UserRetrieveMentionsParams\MediaType|value-of<UserRetrieveMentionsParams\MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   pageSize?: int,
     *   quotes?: UserRetrieveMentionsParams\Quotes|value-of<UserRetrieveMentionsParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: UserRetrieveMentionsParams\Replies|value-of<UserRetrieveMentionsParams\Replies>,
     *   ownThreads?: UserRetrieveMentionsParams\OwnThreads|value-of<UserRetrieveMentionsParams\OwnThreads>,
     *   retweets?: UserRetrieveMentionsParams\Retweets|value-of<UserRetrieveMentionsParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   sinceTime?: string,
     *   source?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
     * }|UserRetrieveMentionsParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveMentionsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/mentions', $id],
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * Returns target-authored posts and replies. Omit mode for automatic maximum coverage. Pass next_cursor unchanged. Unprefixed cursors stay legacy. Excludes other-author context.
     *
     * @param string $id target user ID or username for the replies timeline
     * @param array{
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   imageShows?: string,
     *   includeParentTweet?: bool,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: UserRetrieveRepliesParams\MediaType|value-of<UserRetrieveRepliesParams\MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   pageSize?: int,
     *   quotes?: UserRetrieveRepliesParams\Quotes|value-of<UserRetrieveRepliesParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: UserRetrieveRepliesParams\Replies|value-of<UserRetrieveRepliesParams\Replies>,
     *   retweets?: UserRetrieveRepliesParams\Retweets|value-of<UserRetrieveRepliesParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   source?: string,
     *   topic?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
     * }|UserRetrieveRepliesParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveRepliesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/replies', $id],
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * Search users by name or username
     *
     * @param array{
     *   q: string,
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|UserRetrieveSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers>
     *
     * @throws APIException
     */
    public function retrieveSearch(
        array|UserRetrieveSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveSearchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/users/search',
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * Omit mode for automatic maximum coverage. Pass next_cursor unchanged. Unprefixed cursors use legacy pagination. Shape and billing stay the same.
     *
     * @param string $id X user ID or username
     * @param array{
     *   anyWords?: string,
     *   blueVerifiedOnly?: bool,
     *   cardName?: string,
     *   cashtags?: string,
     *   conversationID?: string,
     *   cursor?: string,
     *   exactPhrase?: string,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   imageShows?: string,
     *   includeParentTweet?: bool,
     *   includeReplies?: bool,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   maxFaves?: int,
     *   maxID?: string,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: UserRetrieveTweetsParams\MediaType|value-of<UserRetrieveTweetsParams\MediaType>,
     *   mentioning?: string,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   pageSize?: int,
     *   quotes?: UserRetrieveTweetsParams\Quotes|value-of<UserRetrieveTweetsParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   replies?: UserRetrieveTweetsParams\Replies|value-of<UserRetrieveTweetsParams\Replies>,
     *   retweets?: UserRetrieveTweetsParams\Retweets|value-of<UserRetrieveTweetsParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   source?: string,
     *   topic?: string,
     *   toUser?: string,
     *   untilDate?: string,
     *   url?: string,
     *   verifiedOnly?: bool,
     *   within?: string,
     *   withinTime?: string,
     * }|UserRetrieveTweetsParams $params
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveTweetsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/tweets', $id],
            query: Util::array_transform_keys(
                $parsed,
                [
                    'conversationID' => 'conversationId',
                    'inReplyToTweetID' => 'inReplyToTweetId',
                    'maxID' => 'maxId',
                    'quotesOfTweetID' => 'quotesOfTweetId',
                    'retweetsOfTweetID' => 'retweetsOfTweetId',
                    'sinceID' => 'sinceId',
                ],
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * List verified followers of a user
     *
     * @param string $id User ID or username for verified followers
     * @param array{
     *   after?: string,
     *   bioContains?: string,
     *   cursor?: string,
     *   hasLocation?: bool,
     *   hasWebsite?: bool,
     *   limit?: int,
     *   locationContains?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxStatuses?: int,
     *   minAccountAgeDays?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minStatuses?: int,
     *   mode?: UserRetrieveVerifiedFollowersParams\Mode|value-of<UserRetrieveVerifiedFollowersParams\Mode>,
     *   pageSize?: int,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     * }|UserRetrieveVerifiedFollowersParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedUsers|UserGetVerifiedFollowersResponse\UserListCoverageResponse,>
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        array|UserRetrieveVerifiedFollowersParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveVerifiedFollowersParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/verified-followers', $id],
            query: $parsed,
            options: $options,
            convert: UserGetVerifiedFollowersResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the newest posts of up to 20 users, named by user ID, username or profile link, in the order named. Send ids or usernames, not both. Each post costs 1 credit. A user in unavailable_ids or unprocessed_ids costs nothing.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveBatchTweetsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/users/batch/tweets',
            query: $parsed,
            options: $options,
            convert: BatchUserTweets::class,
        );
    }

    /**
     * @api
     *
     * Blocks a user through a connected X account. X removes follows both ways, and unblocking doesn't restore them.
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
    ): BaseResponse {
        [$parsed, $options] = UserBlockParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/users/%1$s/block', $id],
            body: (object) $parsed,
            options: $options,
            convert: XWriteAction::class,
        );
    }

    /**
     * @api
     *
     * Unblocks a user through a connected X account.
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
    ): BaseResponse {
        [$parsed, $options] = UserUnblockParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/users/%1$s/block', $id],
            body: (object) $parsed,
            options: $options,
            convert: XWriteAction::class,
        );
    }

    /**
     * @api
     *
     * Mutes a user through a connected X account. The user's posts leave that account's timelines, and X doesn't tell the user.
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
    ): BaseResponse {
        [$parsed, $options] = UserMuteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['x/users/%1$s/mute', $id],
            body: (object) $parsed,
            options: $options,
            convert: XWriteAction::class,
        );
    }

    /**
     * @api
     *
     * Unmutes a user through a connected X account.
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
    ): BaseResponse {
        [$parsed, $options] = UserUnmuteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['x/users/%1$s/mute', $id],
            body: (object) $parsed,
            options: $options,
            convert: XWriteAction::class,
        );
    }

    /**
     * @api
     *
     * Returns the accounts an organization lists as its affiliates, in X's order. An account without affiliates returns an empty list.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveAffiliatesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/affiliates', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * Returns the creators the selected user subscribes to, in X's order. An account that hides its subscriptions returns an empty list.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveSubscriptionsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/subscriptions', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * Returns the public X Lists the selected user created, in X's order, as the profile's Lists tab shows them. Each List costs 1 credit. A protected account answers 403.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveListsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/lists', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedLists::class,
        );
    }

    /**
     * @api
     *
     * Returns the public X Lists that include the selected user, as the profile's List memberships page shows them. Each List costs 1 credit. A protected account answers 403.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveListMembershipsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/list-memberships', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedLists::class,
        );
    }

    /**
     * @api
     *
     * Returns the posts on the user's Articles tab, newest first. Each post's `article` holds the Article's ID, title, preview, cover & dates. Read the full text with GET /x/articles/{tweetId}.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveArticlesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/articles', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedTweets2::class,
        );
    }

    /**
     * @api
     *
     * Returns the posts on the user's Highlights tab, in X's order. An account without highlights returns an empty list.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveHighlightsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/highlights', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedTweets2::class,
        );
    }

    /**
     * @api
     *
     * Returns the public accounts X lists as similar to the selected user, in X's order. Each account costs 1 credit.
     *
     * Similar-account lists come back fuller.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveSimilarParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/similar', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUsers::class,
        );
    }

    /**
     * @api
     *
     * Returns X's own translation of 1 profile's bio into the language you pick, with the links, mentions, and tags X places in the translated text. A profile without a bio returns translation null & a message, free of charge.
     *
     * Posts & bios can be translated into your language.
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
    ): BaseResponse {
        [$parsed, $options] = UserTranslateBioParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/translation', $id],
            query: $parsed,
            options: $options,
            convert: UserTranslateBioResponse::class,
        );
    }

    /**
     * @api
     *
     * Reads the newest followers of a public account & returns a follower audit. It gives each follower 1 class with its score & signals, then adds coverage, a quality score, signal counts, arrival bands, join cohorts, countries, top followers & the account's engagement. Each follower read costs 1 credit, and the engagement adds 1 credit. Signals come from public profiles, so a real person can match. Older followers may differ from the newest ones.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowerAuditParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/follower-audit', $id],
            query: $parsed,
            options: $options,
            convert: UserRetrieveFollowerAuditResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns engagement insights for 1 profile. They are engagement rate, averages per post and posting rate, from its counts and its most recent posts. It reads 20 posts unless limit names another number. Reposts and the pinned post stay out of the averages. Each report costs 1 credit, whatever it reads.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveInsightsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/insights', $id],
            query: $parsed,
            options: $options,
            convert: UserRetrieveInsightsResponse::class,
        );
    }

    /**
     * @api
     *
     * Says whether 1 user is broadcasting live video on X right now, with their latest broadcast, live or ended. Each check costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveLiveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/live', $id],
            query: $parsed,
            options: $options,
            convert: UserLiveStatus::class,
        );
    }

    /**
     * @api
     *
     * Checks 1 X account for a search ban, a search suggestion ban, reply deboosting & a reply lock. It also tests timeline visibility & early engagement, reads the sensitive flag & the countries that withhold the account, and says if the account is active, protected or suspended.
     *
     * Each check answers pass, fail or unknown, with its reason & what it read. `overall` sums up the checks, and `checkedAt` holds the time of the check. The reply checks and the engagement check answer pass or unknown, since X ranks replies for each viewer and a drop alone proves nothing. A protected account skips the checks that need public posts, and a suspended account gets the account check only. Each profile, post, suggestion & reply in the answer costs 1 credit.
     *
     * The timeline, engagement & reply checks read the account's 20 most recent posts unless `limit` names another number.
     *
     * Shadowban checks show if X search lists an account, with each post they read.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveShadowbanParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/shadowban', $id],
            query: $parsed,
            options: $options,
            convert: ShadowbanReport::class,
        );
    }

    /**
     * @api
     *
     * Returns the user IDs of the selected user's followers, newest first, up to 5,000 a page. Use it when you need IDs only. Each ID costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowerIdsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/follower-ids', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUserIDs::class,
        );
    }

    /**
     * @api
     *
     * Returns the user IDs of the accounts the selected user follows, newest first, up to 5,000 a page. Use it when you need IDs only. Each ID costs 1 credit.
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
    ): BaseResponse {
        [$parsed, $options] = UserRetrieveFollowingIdsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s/following-ids', $id],
            query: $parsed,
            options: $options,
            convert: PaginatedUserIDs::class,
        );
    }
}
