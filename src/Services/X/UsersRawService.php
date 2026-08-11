<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\UsersRawContract;
use XTwitterScraper\UserProfile;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse;
use XTwitterScraper\X\Users\UserGetFollowingResponse;
use XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse;
use XTwitterScraper\X\Users\UserRemoveFollowerParams;
use XTwitterScraper\X\Users\UserRemoveFollowerResponse;
use XTwitterScraper\X\Users\UserRetrieveBatchParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersParams;
use XTwitterScraper\X\Users\UserRetrieveFollowersParams\Mode;
use XTwitterScraper\X\Users\UserRetrieveFollowersYouKnowParams;
use XTwitterScraper\X\Users\UserRetrieveFollowingParams;
use XTwitterScraper\X\Users\UserRetrieveLikesParams;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\MediaType;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Quotes;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Replies;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Retweets;
use XTwitterScraper\X\Users\UserRetrieveMediaParams;
use XTwitterScraper\X\Users\UserRetrieveMentionsParams;
use XTwitterScraper\X\Users\UserRetrieveRepliesParams;
use XTwitterScraper\X\Users\UserRetrieveSearchParams;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams;
use XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<UserProfile>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/users/%1$s', $id],
            options: $requestOptions,
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
}
