<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedLists;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\PaginatedUsers;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\ListsContract;
use XTwitterScraper\X\Lists\ListRetrieveFollowersParams\Mode;
use XTwitterScraper\X\Lists\ListRetrieveResponse;
use XTwitterScraper\X\Lists\ListRetrieveTweetsParams\MediaType;
use XTwitterScraper\X\Lists\ListRetrieveTweetsParams\Quotes;
use XTwitterScraper\X\Lists\ListRetrieveTweetsParams\Replies;
use XTwitterScraper\X\Lists\ListRetrieveTweetsParams\Retweets;

/**
 * X List followers, members, and tweets.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class ListsService implements ListsContract
{
    /**
     * @api
     */
    public ListsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ListsRawService($client);
    }

    /**
     * @api
     *
     * List followers of an X List
     *
     * @param string $id List ID
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for list followers
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
     * @param Mode|value-of<Mode>|null $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param string|null $after Legacy cursor alias. Prefer cursor.
     * @param int|null $maxScan Most profiles 1 request reads, kept or dropped by the filters. The request then answers the profiles it kept, the count it dropped & the cursor to read on. Each request of a cursor may send its own value. Without it, a filtered read scans at most 100,000 profiles of the list across all its pages, & the page that reaches them ends the list with `scanLimit`. An unfiltered read has no scan limit. Automatic mode only.
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveFollowers(
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
        Mode|string|null $mode = null,
        ?string $after = null,
        ?int $maxScan = null,
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxScan' => $maxScan, 'after' => $after, 'mode' => $mode,
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
        $response = $this->raw->retrieveFollowers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List members of an X List
     *
     * @param string $id List ID for member lookup
     * @param string $bioContains match any comma-separated or line-separated bio term, ignoring case
     * @param string $cursor Pagination cursor for list members
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
     * @param int $pageSize Members per page (20-200, default 20)
     * @param string $usernameContains match a username substring, ignoring case
     * @param bool $verifiedOnly only return verified profiles
     * @param string $verifiedType match the verification type exactly, ignoring case
     * @param \XTwitterScraper\X\Lists\ListRetrieveMembersParams\Mode|value-of<\XTwitterScraper\X\Lists\ListRetrieveMembersParams\Mode>|null $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param string|null $after Legacy cursor alias. Prefer cursor.
     * @param int|null $maxScan Most profiles 1 request reads, kept or dropped by the filters. The request then answers the profiles it kept, the count it dropped & the cursor to read on. Each request of a cursor may send its own value. Without it, a filtered read scans at most 100,000 profiles of the list across all its pages, & the page that reaches them ends the list with `scanLimit`. An unfiltered read has no scan limit. Automatic mode only.
     * @param bool|null $blueVerifiedOnly Only return profiles X marks as blue verified. X marks many business & government accounts blue too. Use verifiedType for 1 badge type.
     * @param bool|null $hasEmail only return profiles that publish an email
     * @param bool|null $businessEmailOnly only return profiles that publish an email outside free webmail, such as Gmail
     * @param string|null $emailDomains Only return profiles with an email at one of these domains. Separate domains with commas. Subdomains match.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveMembers(
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
        int $pageSize = 20,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        \XTwitterScraper\X\Lists\ListRetrieveMembersParams\Mode|string|null $mode = null,
        ?string $after = null,
        ?int $maxScan = null,
        ?bool $blueVerifiedOnly = null,
        ?bool $hasEmail = null,
        ?bool $businessEmailOnly = null,
        ?string $emailDomains = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedUsers {
        $params = Util::removeNulls(
            ['omit' => $omit, 'fields' => $fields, 'emailDomains' => $emailDomains, 'businessEmailOnly' => $businessEmailOnly, 'hasEmail' => $hasEmail, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxScan' => $maxScan, 'after' => $after, 'mode' => $mode,
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
        $response = $this->raw->retrieveMembers($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List tweets from an X List
     *
     * @param string $id List ID for tweet lookup
     * @param string $cursor Pagination cursor for list tweets
     * @param bool $includeReplies Include replies (default false)
     * @param int $pageSize Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     * @param string $sinceTime Unix timestamp - filter after
     * @param string $untilTime Unix timestamp - filter before
     * @param string|null $after Legacy cursor alias. Prefer cursor.
     * @param \XTwitterScraper\X\Lists\ListRetrieveTweetsParams\Mode|value-of<\XTwitterScraper\X\Lists\ListRetrieveTweetsParams\Mode>|null $mode Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
     * @param string|null $fromUser Filter by author username. Account searches include all of the account's posts & reposts.
     * @param string|null $toUser filter replies sent to a username
     * @param string|null $mentioning filter tweets mentioning a username
     * @param string|null $language Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     * @param string|null $sinceDate Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     * @param string|null $untilDate end date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count
     * @param MediaType|value-of<MediaType>|null $mediaType Filter media. Its aliases are has_video & has_media.
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
     * @param string|null $cardName Keep only Tweets with this card type, such as poll2choice_text_only. Every returned Tweet has it.
     * @param string|null $source `source` isn't supported. A Tweet search with it answers 424 & charges nothing.
     * @param string|null $excludeSource `excludeSource` isn't supported. A Tweet search with it answers 424 & charges nothing.
     * @param string|null $geocode `geocode` isn't supported. A Tweet search with it answers 424 & charges nothing.
     * @param string|null $sinceID Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     * @param string|null $maxID return Tweets at or below this ID
     * @param string|null $near A place name, such as a city or a country. Matching Tweets are tagged in or about that place.
     * @param string|null $within `within` isn't supported. A Tweet search with it answers 424 & charges nothing. Use near alone.
     * @param string|null $withinTime Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     * @param bool|null $nativeRetweets only return native reposts
     * @param bool|null $safe enable the safe-search filter
     * @param bool|null $news `news` isn't supported. A Tweet search with it answers 424 & charges nothing.
     * @param string|null $keywords words the Tweets must match, in X search syntax
     * @param string|null $place search within a place ID
     * @param string|null $placeCountry search within a country code
     * @param string|null $pointRadius Geo point radius, such as -73.99 40.73 25mi.
     * @param string|null $boundingBox Geo bounding box, such as -74.1 40.6 -73.9 40.8.
     * @param string|null $advancedQuery raw advanced search query appended as-is
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
    public function retrieveTweets(
        string $id,
        ?string $cursor = null,
        ?bool $includeReplies = null,
        int $pageSize = 20,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        ?string $after = null,
        \XTwitterScraper\X\Lists\ListRetrieveTweetsParams\Mode|string|null $mode = null,
        ?string $fromUser = null,
        ?string $toUser = null,
        ?string $mentioning = null,
        ?string $language = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        MediaType|string|null $mediaType = null,
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
        ?string $cardName = null,
        ?string $source = null,
        ?string $excludeSource = null,
        ?string $geocode = null,
        ?string $sinceID = null,
        ?string $maxID = null,
        ?string $near = null,
        ?string $within = null,
        ?string $withinTime = null,
        ?bool $nativeRetweets = null,
        ?bool $safe = null,
        ?bool $news = null,
        ?string $keywords = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        ?string $boundingBox = null,
        ?string $advancedQuery = null,
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
            ['omit' => $omit, 'fields' => $fields, 'retweetsOfTweetID' => $retweetsOfTweetID, 'quotesOfTweetID' => $quotesOfTweetID, 'inReplyToTweetID' => $inReplyToTweetID, 'conversationID' => $conversationID, 'url' => $url, 'cashtags' => $cashtags, 'hashtags' => $hashtags, 'anyWords' => $anyWords, 'excludeWords' => $excludeWords, 'exactPhrase' => $exactPhrase, 'quotes' => $quotes, 'retweets' => $retweets, 'replies' => $replies, 'verifiedOnly' => $verifiedOnly, 'advancedQuery' => $advancedQuery, 'boundingBox' => $boundingBox, 'pointRadius' => $pointRadius, 'placeCountry' => $placeCountry, 'place' => $place, 'keywords' => $keywords, 'news' => $news, 'safe' => $safe, 'nativeRetweets' => $nativeRetweets, 'withinTime' => $withinTime, 'within' => $within, 'near' => $near, 'maxID' => $maxID, 'sinceID' => $sinceID, 'geocode' => $geocode, 'excludeSource' => $excludeSource, 'source' => $source, 'cardName' => $cardName, 'blueVerifiedOnly' => $blueVerifiedOnly, 'maxQuotes' => $maxQuotes, 'maxReplies' => $maxReplies, 'maxRetweets' => $maxRetweets, 'maxFaves' => $maxFaves, 'minBookmarks' => $minBookmarks, 'minViews' => $minViews, 'minQuotes' => $minQuotes, 'minReplies' => $minReplies, 'minRetweets' => $minRetweets, 'minLikes' => $minLikes, 'mediaType' => $mediaType, 'untilDate' => $untilDate, 'sinceDate' => $sinceDate, 'language' => $language, 'mentioning' => $mentioning, 'toUser' => $toUser, 'fromUser' => $fromUser, 'mode' => $mode, 'after' => $after,
                'cursor' => $cursor,
                'includeReplies' => $includeReplies,
                'pageSize' => $pageSize,
                'sinceTime' => $sinceTime,
                'untilTime' => $untilTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveTweets($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns 1 page of public Lists with member counts, banners & owner profiles. X may rank the Lists differently per request. Pass next_cursor as cursor for the next page.
     *
     * @param string $q Keywords to find Lists by, such as a topic. Alias query. Xquik's cap is 4,096 characters.
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveSearch(
        string $q,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedLists {
        $params = Util::removeNulls(
            [
                'q' => $q,
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveSearch(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns 1 public X List as its page on X shows it. Accepts the List ID or the URL-encoded List URL, such as x.com/i/lists/4143408. A private List answers 404 list_not_found.
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): ListRetrieveResponse {
        $params = Util::removeNulls(
            [
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
