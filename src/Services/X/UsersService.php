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
use XTwitterScraper\X\Users\UserRemoveFollowerResponse;
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
     * @param string $id User ID to remove from your followers
     * @param string $account X account identifier (@username or account ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function removeFollower(
        string $id,
        string $account,
        RequestOptions|array|null $requestOptions = null,
    ): UserRemoveFollowerResponse {
        $params = Util::removeNulls(['account' => $account]);

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
     * @param string $id User ID or username
     * @param string $after Legacy cursor alias. Prefer cursor.
     * @param string $cursor Pagination cursor for followers list
     * @param int $limit Legacy integer page size alias for following lists. Prefer pageSize.
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowers(
        string $id,
        ?string $after = null,
        ?string $cursor = null,
        ?int $limit = null,
        int $pageSize = 200,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'after' => $after,
                'cursor' => $cursor,
                'limit' => $limit,
                'pageSize' => $pageSize,
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
     * @param string $cursor Pagination cursor for followers-you-know
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowersYouKnow(
        string $id,
        ?string $cursor = null,
        int $pageSize = 200,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

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
     * @param string $after Legacy cursor alias. Prefer cursor.
     * @param string $cursor Pagination cursor for following list
     * @param int $limit Legacy page size alias. Prefer pageSize.
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowing(
        string $id,
        ?string $after = null,
        ?string $cursor = null,
        ?int $limit = null,
        int $pageSize = 200,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            [
                'after' => $after,
                'cursor' => $cursor,
                'limit' => $limit,
                'pageSize' => $pageSize,
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
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for liked tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param MediaType|value-of<MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param Quotes|value-of<Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param Replies|value-of<Replies> $replies reply mode
     * @param Retweets|value-of<Retweets> $retweets retweet mode
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
    public function retrieveLikes(
        string $id,
        ?string $anyWords = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        int $pageSize = 20,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
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
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
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
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for media tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets> $retweets retweet mode
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
    public function retrieveMedia(
        string $id,
        ?string $anyWords = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveMediaParams\Retweets|string|null $retweets = null,
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
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
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
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for mentions
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets> $retweets retweet mode
     * @param string $retweetsOfTweetID only retweets of this tweet ID
     * @param string $sinceDate start date in YYYY-MM-DD format
     * @param string $sinceTime Unix timestamp - return mentions after this time
     * @param string $toUser filter replies sent to a username
     * @param string $untilDate end date in YYYY-MM-DD format
     * @param string $untilTime Unix timestamp - return mentions before this time
     * @param string $url URL substring or domain filter
     * @param bool $verifiedOnly only return tweets from verified authors
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMentions(
        string $id,
        ?string $anyWords = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveMentionsParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $sinceTime = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            [
                'anyWords' => $anyWords,
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'pageSize' => $pageSize,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'replies' => $replies,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'sinceDate' => $sinceDate,
                'sinceTime' => $sinceTime,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'verifiedOnly' => $verifiedOnly,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveMentions($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the user's timeline with replies included by default.
     *
     * @param string $id X user ID or username
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for user replies
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $includeParentTweet Include parent tweet for replies
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets> $retweets retweet mode
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
    public function retrieveReplies(
        string $id,
        ?string $anyWords = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        bool $includeParentTweet = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveRepliesParams\Retweets|string|null $retweets = null,
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
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'includeParentTweet' => $includeParentTweet,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
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
        $response = $this->raw->retrieveReplies($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Search users by name or username
     *
     * @param string $q User search query
     * @param string $cursor Pagination cursor for user search
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $q,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(['q' => $q, 'cursor' => $cursor]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List recent tweets posted by a user
     *
     * @param string $id X user ID or username
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string $cashtags cashtags separated by spaces, commas, or lines
     * @param string $conversationID conversation ID filter
     * @param string $cursor Pagination cursor for user tweets
     * @param string $exactPhrase exact phrase to match
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string $fromUser filter by author username
     * @param string $hashtags hashtags separated by spaces, commas, or lines
     * @param bool $includeParentTweet Include parent tweet for replies
     * @param bool $includeReplies Include reply tweets
     * @param string $inReplyToTweetID only replies to this tweet ID
     * @param string $language Language code filter, e.g. en or tr.
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType> $mediaType filter by media type
     * @param string $mentioning filter tweets mentioning a username
     * @param int $minFaves minimum likes threshold
     * @param int $minQuotes minimum quote count threshold
     * @param int $minReplies minimum replies threshold
     * @param int $minRetweets minimum retweets threshold
     * @param int $pageSize Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes> $quotes quote mode
     * @param string $quotesOfTweetID only quotes of this tweet ID
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies> $replies reply mode
     * @param \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets|value-of<\XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets> $retweets retweet mode
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
    public function retrieveTweets(
        string $id,
        ?string $anyWords = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        bool $includeParentTweet = false,
        bool $includeReplies = false,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets|string|null $retweets = null,
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
                'cashtags' => $cashtags,
                'conversationID' => $conversationID,
                'cursor' => $cursor,
                'exactPhrase' => $exactPhrase,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'hashtags' => $hashtags,
                'includeParentTweet' => $includeParentTweet,
                'includeReplies' => $includeReplies,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minFaves' => $minFaves,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
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
        $response = $this->raw->retrieveTweets($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List verified followers of a user
     *
     * @param string $id User ID or username for verified followers
     * @param string $cursor Pagination cursor for verified followers
     * @param int $pageSize Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveVerifiedFollowers(
        string $id,
        ?string $cursor = null,
        int $pageSize = 200,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(['cursor' => $cursor, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveVerifiedFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
