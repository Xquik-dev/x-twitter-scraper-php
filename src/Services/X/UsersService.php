<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\UsersContract;
use XTwitterScraper\Services\X\Users\FollowService;
use XTwitterScraper\UserProfile;
use XTwitterScraper\X\Users\UserGetBatchResponse;
use XTwitterScraper\X\Users\UserGetFollowersResponse\UserListCoverageResponse;
use XTwitterScraper\X\Users\UserRemoveFollowerResponse;
use XTwitterScraper\X\Users\UserRetrieveFollowersParams\Mode;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\MediaType;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Quotes;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Replies;
use XTwitterScraper\X\Users\UserRetrieveLikesParams\Retweets;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class UsersService implements UsersContract
{
    /**
     * @api
     */
    public UsersRawService $raw;

    /**
     * @api
     */
    public FollowService $follow;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new UsersRawService($client);
        $this->follow = new FollowService($client);
    }

    /**
     * @api
     *
     * Get user profile with follower counts and verification
     *
     * @param string $id X username (without @) or user ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): UserProfile {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove follower
     *
     * @param string $id Path param: User ID to remove from your followers
     * @param string $account Body param: X account identifier (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function removeFollower(
        string $id,
        string $account,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): UserRemoveFollowerResponse {
        $params = Util::removeNulls(
            ['account' => $account, 'idempotencyKey' => $idempotencyKey]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->removeFollower($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Look up multiple users by IDs in one call
     *
     * @param string $ids Comma-separated numeric user IDs (1-100 values). Duplicate IDs are ignored while preserving first-seen order.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveBatch(
        string $ids,
        RequestOptions|array|null $requestOptions = null
    ): UserGetBatchResponse {
        $params = Util::removeNulls(['ids' => $ids]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveBatch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List followers of a user
     *
     * @param string $id target user ID or username for follower lookup
     * @param string $after Legacy cursor alias. Prefer cursor.
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param int $limit Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param Mode|value-of<Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param int $pageSize Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        ?string $after = null,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?int $limit = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        Mode|string|null $mode = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers|UserListCoverageResponse {
        $params = Util::removeNulls(
            [
                'after' => $after,
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'limit' => $limit,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'mode' => $mode,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List mutual followers between you and a user
     *
     * @param string $id User ID for followers-you-know lookup
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for followers-you-know
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). Source, filters, or credits can return fewer profiles. Keep requesting next_cursor while has_next_page is true. Deprecated aliases remain accepted.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowersYouKnow(
        string $id,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowersYouKnow($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List accounts a user follows
     *
     * @param string $id User ID or username for following lookup
     * @param string $after Deprecated following cursor alias. Prefer cursor.
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param int $limit Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveFollowingParams\Mode|value-of<\XTwitterScraper\X\Users\UserRetrieveFollowingParams\Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param int $pageSize Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        ?string $after = null,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?int $limit = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        \XTwitterScraper\X\Users\UserRetrieveFollowingParams\Mode|string|null $mode = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers|\XTwitterScraper\X\Users\UserGetFollowingResponse\UserListCoverageResponse {
        $params = Util::removeNulls(
            [
                'after' => $after,
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'limit' => $limit,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'mode' => $mode,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveFollowing($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets liked by a user
     *
     * @param string $id User ID or username
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for liked tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param MediaType|value-of<MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param Quotes|value-of<Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param Replies|value-of<Replies> $replies reply mode
     * @param Retweets|value-of<Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveLikes(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveLikes($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List media tweets posted by a user
     *
     * @param string $id User ID or username for media lookup
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for media tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMedia(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMedia($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets mentioning a user
     *
     * @param string $id User ID or username for mentions lookup
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for mentions
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $sinceTime Unix timestamp - return mentions after this time
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return mentions before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMentions(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $sinceTime = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'sinceTime' => $sinceTime,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMentions($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns target-authored posts and replies. Omit mode for automatic maximum coverage. Pass next_cursor unchanged. Unprefixed cursors stay legacy. Excludes other-author context.
     *
     * @param string $id target user ID or username for the replies timeline
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $includeParentTweet include each reply's parent tweet
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveReplies(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        bool $includeParentTweet = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'includeParentTweet' => $includeParentTweet,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveReplies($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search users by name or username
     *
     * @param string $q User search query
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for user search
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $q,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'q' => $q,
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Omit mode for automatic maximum coverage. Pass next_cursor unchanged. Unprefixed cursors use legacy pagination. Shape and billing stay the same.
     *
     * @param string $id X user ID or username
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $includeParentTweet Include parent tweet for replies
     * @param bool $includeReplies Include reply tweets
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveTweets(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        bool $includeParentTweet = false,
        bool $includeReplies = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'includeParentTweet' => $includeParentTweet,
                'includeReplies' => $includeReplies,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
                'maxID' => $maxID,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'source' => $source,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTweets($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List verified followers of a user
     *
     * @param string $id User ID or username for verified followers
     * @param string $after Legacy cursor alias. Prefer cursor.
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param bool $hasLocation only return profiles with a location
     * @param bool $hasWebsite only return profiles with a website
     * @param int $limit Legacy page-size alias outside explicit coverage mode. Coverage accepts 1-10000. Prefer pageSize.
     * @param string $locationContains match a location substring, ignoring case
     * @param int $maxFollowers Maximum follower count. Missing counts pass this maximum.
     * @param int $maxFollowing maximum following count
     * @param int $maxStatuses Maximum post count. maxPosts is also accepted.
     * @param int $minAccountAgeDays minimum account age in whole days
     * @param int $minFollowers Minimum follower count. Filtering happens before billing.
     * @param int $minFollowing minimum following count
     * @param int $minStatuses Minimum post count. minPosts is also accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams\Mode|value-of<\XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams\Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param int $pageSize Maximum user profiles: automatic 300; standard 200. Sources return fewer profiles. Continue with has_next_page.
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        ?string $after = null,
        ?string $bioContains = null,
        ?string $cursor = null,
        ?bool $hasLocation = null,
        ?bool $hasWebsite = null,
        ?int $limit = null,
        ?string $locationContains = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxStatuses = null,
        ?int $minAccountAgeDays = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minStatuses = null,
        \XTwitterScraper\X\Users\UserRetrieveVerifiedFollowersParams\Mode|string|null $mode = null,
        int $pageSize = 200,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers|\XTwitterScraper\X\Users\UserGetVerifiedFollowersResponse\UserListCoverageResponse {
        $params = Util::removeNulls(
            [
                'after' => $after,
                'bioContains' => $bioContains,
                'cursor' => $cursor,
                'hasLocation' => $hasLocation,
                'hasWebsite' => $hasWebsite,
                'limit' => $limit,
                'locationContains' => $locationContains,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxStatuses' => $maxStatuses,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minStatuses' => $minStatuses,
                'mode' => $mode,
                'pageSize' => $pageSize,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveVerifiedFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
