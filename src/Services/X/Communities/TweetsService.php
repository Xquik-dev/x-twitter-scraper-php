<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X\Communities;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\Communities\TweetsContract;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\MediaType;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\QueryType;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\Quotes;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\Replies;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\Retweets;

/**
 * X Community info, members, and tweets.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class TweetsService implements TweetsContract
{
    /**
     * @api
     */
    public TweetsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TweetsRawService($client);
    }

    /**
     * @api
     *
     * Requires a Community ID and keyword query.
     *
     * @param string $communityID Numeric ID of the community to search
     * @param string $q Keyword query within the selected community
     * @param string $cursor Pagination cursor for community results
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param QueryType|value-of<QueryType> $queryType Sort order for community results (Latest or Top)
     * @param string|null $language Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     * @param string|null $fromUser Filter by author username. Account searches include all of the account's posts & reposts.
     * @param string|null $toUser filter replies sent to a username
     * @param string|null $mentioning filter tweets mentioning a username
     * @param string|null $sinceDate Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     * @param string|null $untilDate end date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count
     * @param string|null $withinTime Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     * @param MediaType|value-of<MediaType>|null $mediaType Filter media. Its aliases are has_video & has_media.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param int|null $minRetweets minimum retweets threshold
     * @param int|null $minReplies minimum replies threshold
     * @param int|null $minViews minimum view count threshold
     * @param int|null $minQuotes minimum quote count threshold
     * @param int|null $minBookmarks minimum bookmark count threshold
     * @param int|null $maxFaves Maximum likes threshold. maxLikes & max_likes also work.
     * @param int|null $maxRetweets maximum retweets threshold
     * @param int|null $maxReplies maximum replies threshold
     * @param int|null $maxQuotes maximum quotes threshold
     * @param bool|null $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string|null $sinceID Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     * @param string|null $maxID return Tweets at or below this ID
     * @param bool|null $nativeRetweets only return native reposts
     * @param bool|null $verifiedOnly only return tweets from verified authors
     * @param Replies|value-of<Replies>|null $replies Reply mode. Exclude keeps own-thread replies.
     * @param Retweets|value-of<Retweets>|null $retweets only when the caller requests a repost mode
     * @param Quotes|value-of<Quotes>|null $quotes only when the caller requests a quote mode
     * @param string|null $exactPhrase match this exact phrase, word for word
     * @param string|null $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string|null $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string|null $hashtags hashtags separated by spaces, commas, or lines
     * @param string|null $cashtags cashtags separated by spaces, commas, or lines
     * @param string|null $url URL substring or domain filter
     * @param string|null $conversationID conversation ID filter
     * @param string|null $inReplyToTweetID only replies to this tweet ID
     * @param string|null $quotesOfTweetID only quotes of this tweet ID
     * @param string|null $retweetsOfTweetID only retweets of this tweet ID
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $communityID,
        string $q,
        ?string $cursor = null,
        int $pageSize = 20,
        QueryType|string $queryType = 'Latest',
        ?string $language = null,
        ?string $fromUser = null,
        ?string $toUser = null,
        ?string $mentioning = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        ?string $withinTime = null,
        MediaType|string|null $mediaType = null,
        ?int $minLikes = null,
        ?int $minRetweets = null,
        ?int $minReplies = null,
        ?int $minViews = null,
        ?int $minQuotes = null,
        ?int $minBookmarks = null,
        ?int $maxFaves = null,
        ?int $maxRetweets = null,
        ?int $maxReplies = null,
        ?int $maxQuotes = null,
        ?bool $blueVerifiedOnly = null,
        ?string $sinceID = null,
        ?string $maxID = null,
        ?bool $nativeRetweets = null,
        ?bool $verifiedOnly = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        Quotes|string|null $quotes = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $anyWords = null,
        ?string $hashtags = null,
        ?string $cashtags = null,
        ?string $url = null,
        ?string $conversationID = null,
        ?string $inReplyToTweetID = null,
        ?string $quotesOfTweetID = null,
        ?string $retweetsOfTweetID = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'retweetsOfTweetID' => $retweetsOfTweetID, 'quotesOfTweetID' => $quotesOfTweetID, 'inReplyToTweetID' => $inReplyToTweetID, 'conversationID' => $conversationID, 'url' => $url, 'cashtags' => $cashtags, 'hashtags' => $hashtags, 'anyWords' => $anyWords, 'excludeWords' => $excludeWords, 'exactPhrase' => $exactPhrase, 'quotes' => $quotes, 'retweets' => $retweets, 'replies' => $replies, 'verifiedOnly' => $verifiedOnly, 'nativeRetweets' => $nativeRetweets, 'maxID' => $maxID, 'sinceID' => $sinceID, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxQuotes' => $maxQuotes, 'maxReplies' => $maxReplies, 'maxRetweets' => $maxRetweets, 'maxFaves' => $maxFaves, 'minBookmarks' => $minBookmarks, 'minQuotes' => $minQuotes, 'minViews' => $minViews, 'minReplies' => $minReplies, 'minRetweets' => $minRetweets, 'minLikes' => $minLikes, 'mediaType' => $mediaType, 'withinTime' => $withinTime, 'untilDate' => $untilDate, 'sinceDate' => $sinceDate, 'mentioning' => $mentioning, 'toUser' => $toUser, 'fromUser' => $fromUser, 'language' => $language,
                'communityID' => $communityID,
                'q' => $q,
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'queryType' => $queryType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets posted in a community
     *
     * @param string $id Community ID for tweet lookup
     * @param string $cursor Pagination cursor for community tweets
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\QueryType|value-of<\XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\QueryType>|null $queryType Latest for newest first, or Top for the posts X ranks highest. Any case works. Aliases ranking & sort, which also take Recency & Relevance. Send the same value with each cursor.
     * @param string|null $fromUser Filter by author username. Account searches include all of the account's posts & reposts.
     * @param string|null $toUser filter replies sent to a username
     * @param string|null $mentioning filter tweets mentioning a username
     * @param string|null $language Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     * @param string|null $sinceDate Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     * @param string|null $untilDate end date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count
     * @param \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\MediaType|value-of<\XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\MediaType>|null $mediaType Filter media. Its aliases are has_video & has_media.
     * @param int|null $minLikes Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     * @param int|null $minRetweets minimum retweets threshold
     * @param int|null $minReplies minimum replies threshold
     * @param int|null $minQuotes minimum quote count threshold
     * @param int|null $minViews minimum view count threshold
     * @param int|null $minBookmarks minimum bookmark count threshold
     * @param int|null $maxFaves Maximum likes threshold. maxLikes & max_likes also work.
     * @param int|null $maxRetweets maximum retweets threshold
     * @param int|null $maxReplies maximum replies threshold
     * @param int|null $maxQuotes maximum quotes threshold
     * @param bool|null $blueVerifiedOnly only return tweets from Blue-verified authors
     * @param string|null $sinceID Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     * @param string|null $maxID return Tweets at or below this ID
     * @param string|null $withinTime Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     * @param bool|null $nativeRetweets only return native reposts
     * @param bool|null $verifiedOnly only return tweets from verified authors
     * @param \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Replies|value-of<\XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Replies>|null $replies Reply mode. Exclude keeps own-thread replies.
     * @param \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Retweets|value-of<\XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Retweets>|null $retweets only when the caller requests a repost mode
     * @param \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Quotes|value-of<\XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Quotes>|null $quotes only when the caller requests a quote mode
     * @param string|null $exactPhrase match this exact phrase, word for word
     * @param string|null $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     * @param string|null $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     * @param string|null $hashtags hashtags separated by spaces, commas, or lines
     * @param string|null $cashtags cashtags separated by spaces, commas, or lines
     * @param string|null $url URL substring or domain filter
     * @param string|null $conversationID conversation ID filter
     * @param string|null $inReplyToTweetID only replies to this tweet ID
     * @param string|null $quotesOfTweetID only quotes of this tweet ID
     * @param string|null $retweetsOfTweetID only retweets of this tweet ID
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listByCommunity(
        string $id,
        ?string $cursor = null,
        int $pageSize = 20,
        \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\QueryType|string|null $queryType = null,
        ?string $fromUser = null,
        ?string $toUser = null,
        ?string $mentioning = null,
        ?string $language = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\MediaType|string|null $mediaType = null,
        ?int $minLikes = null,
        ?int $minRetweets = null,
        ?int $minReplies = null,
        ?int $minQuotes = null,
        ?int $minViews = null,
        ?int $minBookmarks = null,
        ?int $maxFaves = null,
        ?int $maxRetweets = null,
        ?int $maxReplies = null,
        ?int $maxQuotes = null,
        ?bool $blueVerifiedOnly = null,
        ?string $sinceID = null,
        ?string $maxID = null,
        ?string $withinTime = null,
        ?bool $nativeRetweets = null,
        ?bool $verifiedOnly = null,
        \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Replies|string|null $replies = null,
        \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Retweets|string|null $retweets = null,
        \XTwitterScraper\X\Communities\Tweets\TweetListByCommunityParams\Quotes|string|null $quotes = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $anyWords = null,
        ?string $hashtags = null,
        ?string $cashtags = null,
        ?string $url = null,
        ?string $conversationID = null,
        ?string $inReplyToTweetID = null,
        ?string $quotesOfTweetID = null,
        ?string $retweetsOfTweetID = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets {
        $params = Util::removeNulls(['omit' => $omit, 'fields' => $fields, 'retweetsOfTweetID' => $retweetsOfTweetID, 'quotesOfTweetID' => $quotesOfTweetID, 'inReplyToTweetID' => $inReplyToTweetID, 'conversationID' => $conversationID, 'url' => $url, 'cashtags' => $cashtags, 'hashtags' => $hashtags, 'anyWords' => $anyWords, 'excludeWords' => $excludeWords, 'exactPhrase' => $exactPhrase, 'quotes' => $quotes, 'retweets' => $retweets, 'replies' => $replies, 'verifiedOnly' => $verifiedOnly, 'nativeRetweets' => $nativeRetweets, 'withinTime' => $withinTime, 'maxID' => $maxID, 'sinceID' => $sinceID, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxQuotes' => $maxQuotes, 'maxReplies' => $maxReplies, 'maxRetweets' => $maxRetweets, 'maxFaves' => $maxFaves, 'minBookmarks' => $minBookmarks, 'minViews' => $minViews, 'minQuotes' => $minQuotes, 'minReplies' => $minReplies, 'minRetweets' => $minRetweets, 'minLikes' => $minLikes, 'mediaType' => $mediaType, 'untilDate' => $untilDate, 'sinceDate' => $sinceDate, 'language' => $language, 'mentioning' => $mentioning, 'toUser' => $toUser, 'fromUser' => $fromUser, 'queryType' => $queryType, 'cursor' => $cursor, 'pageSize' => $pageSize]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listByCommunity($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
