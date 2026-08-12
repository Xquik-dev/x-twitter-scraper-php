<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\TweetsContract;
use XTwitterScraper\Services\X\Tweets\LikeService;
use XTwitterScraper\Services\X\Tweets\RetweetService;
use XTwitterScraper\X\Tweets\TweetDeleteResponse;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\MediaType;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Quotes;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Replies;
use XTwitterScraper\X\Tweets\TweetGetQuotesParams\Retweets;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Mode;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Scope;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Sort;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse;
use XTwitterScraper\X\Tweets\TweetGetResponse;
use XTwitterScraper\X\Tweets\TweetNewResponse;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TweetsService implements TweetsContract
{
    /**
     * @api
     */
    public TweetsRawService $raw;

    /**
     * @api
     */
    public LikeService $like;

    /**
     * @api
     */
    public RetweetService $retweet;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TweetsRawService($client);
        $this->like = new LikeService($client);
        $this->retweet = new RetweetService($client);
    }

    /**
     * @api
     *
     * Create tweet
     *
     * @param string $account Body param: X account (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param string $communityID Body param
     * @param bool $isNoteTweet Body param
     * @param list<string> $media Body param: Array of public media URLs to attach. Supports up to 4 images or exactly 1 MP4 video up to 100 MB. Each URL must be publicly reachable. Attached media adds 2 credits per started MB across all files.
     * @param string $replyToTweetID Body param
     * @param string $text Body param: Tweet text (optional when media is provided)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $account,
        string $idempotencyKey,
        ?string $communityID = null,
        ?bool $isNoteTweet = null,
        ?array $media = null,
        ?string $replyToTweetID = null,
        ?string $text = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetNewResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'idempotencyKey' => $idempotencyKey,
                'communityID' => $communityID,
                'isNoteTweet' => $isNoteTweet,
                'media' => $media,
                'replyToTweetID' => $replyToTweetID,
                'text' => $text,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get tweet with full text, author, metrics and media
     *
     * @param string $id Numeric tweet ID, 15-20 digits
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): TweetGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get multiple tweets by IDs
     *
     * @param string $ids Comma-separated tweet IDs (max 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $ids,
        RequestOptions|array|null $requestOptions = null
    ): PaginatedTweets {
        $params = Util::removeNulls(['ids' => $ids]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete tweet
     *
     * @param string $id Path param: Tweet ID to delete
     * @param string $account Body param: X account identifier (@username or account ID)
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        string $account,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): TweetDeleteResponse {
        $params = Util::removeNulls(
            ['account' => $account, 'idempotencyKey' => $idempotencyKey]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns liker profiles that X makes visible for the post. X can withhold liker identities even when the post reports likes. In that case this endpoint returns 424 `favoriters_unavailable` instead of a misleading empty success.
     *
     * @param string $id Tweet ID to get favoriters
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for favoriters
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
    public function getFavoriters(
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
        $response = $this->raw->getFavoriters($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List quote tweets of a tweet
     *
     * @param string $id Numeric tweet ID to get quotes, 15-20 digits
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for quote tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $includeReplies Include reply quotes (default false)
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
     * @param string $sinceTime Unix timestamp - return quotes posted after this time
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return quotes posted before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getQuotes(
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
        ?bool $includeReplies = null,
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
        $response = $this->raw->getQuotes($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns direct replies. Omit mode for automatic maximum coverage with resumable pagination. Complete mode returns nested replies, diagnostics, and 424 when direct coverage stays below 80%.
     *
     * @param string $id Tweet ID to get replies
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cardName match the Tweet card name
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     * @param string $exactPhrase exact phrase to match
     * @param bool $excludeOriginalAuthor exclude replies written by the source-post author
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $hasMediaOnly only return replies containing media
     * @param bool $includeOriginalPost include the source post and count it toward limit
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $limit With mode=complete, maximum combined direct and nested reply rows (1-25000, default 25000). Automatic pages accept 1-300. Standard pages accept 1-100. Prefer pageSize outside complete mode.
     * @param int $maxDepth maximum reply depth from the source post
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param Mode|value-of<Mode> $mode Optional advanced override. Omit mode for automatic maximum direct reply coverage with pagination. Standard keeps legacy pagination. Complete returns direct and nested replies with diagnostics, scope, depth, sorting, and original-post controls.
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param int $pageSize Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param Scope|value-of<Scope> $scope select all replies, direct replies, or nested replies
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $sinceTime Unix timestamp - return replies posted after this time
     * @param Sort|value-of<Sort> $sort sort the selected replies before applying limit
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return replies posted before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getReplies(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        bool $excludeOriginalAuthor = false,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        bool $hasMediaOnly = false,
        bool $includeOriginalPost = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $limit = null,
        ?int $maxDepth = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        Mode|string|null $mode = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        Scope|string $scope = 'all',
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $sinceTime = null,
        Sort|string $sort = 'relevance',
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): TweetGetRepliesResponse {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeOriginalAuthor' => $excludeOriginalAuthor,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'hasMediaOnly' => $hasMediaOnly,
                'includeOriginalPost' => $includeOriginalPost,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'limit' => $limit,
                'maxDepth' => $maxDepth,
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
                'mode' => $mode,
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
                'scope' => $scope,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'sinceTime' => $sinceTime,
                'sort' => $sort,
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
        $response = $this->raw->getReplies($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List users who retweeted a tweet
     *
     * @param string $id Tweet ID to get retweeters
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for retweeters
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
    public function getRetweeters(
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
        $response = $this->raw->getRetweeters($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get full conversation thread for a tweet
     *
     * @param string $id Tweet ID to get thread context
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for thread tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetGetThreadParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetGetThreadParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getThread(
        string $id,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $maxFaves = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetGetThreadParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'maxFaves' => $maxFaves,
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
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'sinceDate' => $sinceDate,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->getThread($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * No-mode search maximizes coverage. New cursorless `Latest` sessions return rows newest-first across cursor pages. Existing cursors preserve their established ordering.
     *
     * @param string $q Query, Tweet ID, or status URL. Valid inline bounds apply per page.
     * @param string $advancedQuery raw advanced search query appended as-is
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param bool $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string $boundingBox Geo bounding box, e.g. -74.1 40.6 -73.9 40.8.
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
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param int $limit Result upper bound. Omit it for the existing 20-row page size. Explicit coverage defaults to 2000 and allows 10000. For paid requests, remaining credits can reduce results. Zero affordable results returns 402.
     * @param string $listID search within a list ID
     * @param int $maxFaves Maximum likes threshold. maxLikes is also accepted.
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxQuotes maximum quotes threshold
     * @param int $maxReplies maximum replies threshold
     * @param int $maxRetweets maximum retweets threshold
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\MediaType|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minBookmarks minimum bookmark count threshold
     * @param int $minFaves Minimum likes threshold. minLikes is also accepted.
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $minViews minimum view count threshold
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Mode|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Mode> $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param string $place search within a place ID
     * @param string $placeCountry search within a country code
     * @param string $pointRadius Geo point radius, e.g. -73.99 40.73 25mi.
     * @param QueryType|value-of<QueryType> $queryType Sort order - Latest (chronological) or Top (engagement-ranked)
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Quotes|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Replies|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Tweets\TweetSearchParams\Retweets|value-of<\XTwitterScraper\X\Tweets\TweetSearchParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param bool $safe enable the safe-search filter
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param string $sinceTime inclusive ISO bound
     * @param string $source match the source application
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime exclusive ISO bound
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function search(
        string $q,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $boundingBox = null,
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
        ?int $limit = null,
        ?string $listID = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Mode|string|null $mode = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        QueryType|string $queryType = 'Latest',
        \XTwitterScraper\X\Tweets\TweetSearchParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Tweets\TweetSearchParams\Retweets|string|null $retweets = null,
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
    ): PaginatedTweets|TweetSearchCoverageResponse {
        $params = Util::removeNulls(
            [
                'q' => $q,
                'advancedQuery' => $advancedQuery,
                'anyWords' => $anyWords,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'boundingBox' => $boundingBox,
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
                'limit' => $limit,
                'listID' => $listID,
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
                'mode' => $mode,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'place' => $place,
                'placeCountry' => $placeCountry,
                'pointRadius' => $pointRadius,
                'queryType' => $queryType,
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
        $response = $this->raw->search(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
