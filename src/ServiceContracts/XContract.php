<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\SearchSuggestions;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetHashflagsResponse;
use XTwitterScraper\X\XGetNewsStoryVersionsResponse;
use XTwitterScraper\X\XGetNotificationsParams\Type;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendLocationsParams\PlaceType;
use XTwitterScraper\X\XGetTrendLocationsResponse;
use XTwitterScraper\X\XGetTrendsHistoryResponse;
use XTwitterScraper\X\XGetTrendsResponse;
use XTwitterScraper\X\XSearchPlacesResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface XContract
{
    /**
     * @api
     *
     * @param string $tweetID Numeric tweet ID of the article, 15-20 digits. If you have a tweet URL, use the final status ID.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getArticle(
        string $tweetID,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null
    ): XGetArticleResponse;

    /**
     * @api
     *
     * @param string $cursor Pagination cursor for timeline
     * @param string $seenTweetIDs Comma-separated tweet IDs to exclude from results. Empty entries are ignored.
     * @param int $pageSize Items per page, 1 to 100, default 20. Follow the next cursor for more.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getHomeTimeline(
        ?string $cursor = null,
        ?string $seenTweetIDs = null,
        ?int $pageSize = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedTweets;

    /**
     * @api
     *
     * @param string $cursor Pagination cursor for notifications
     * @param Type|value-of<Type> $type Notification type filter. Unrecognized values fall back to All.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getNotifications(
        ?string $cursor = null,
        Type|string $type = 'All',
        RequestOptions|array|null $requestOptions = null,
    ): XGetNotificationsResponse;

    /**
     * @api
     *
     * @param int $count Number of trending topics to return (1-50, default 30)
     * @param int $woeid Region WOEID (1=Worldwide, 23424977=US, 23424975=UK, 23424969=Turkey)
     * @param string|null $country Country to read trends for, by name or 2-letter code, such as Turkey or TR. Case insensitive. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     * @param string|null $location Town or country to read trends for, by name, such as Istanbul. Case insensitive. Add country when 2 towns share a name. /x/trends/locations lists every name. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     * @param string|null $at A past time, to read what was trending on Twitter then. Takes an ISO 8601 time, a date such as 2026-10-13, or Unix seconds. A time without a zone reads as UTC. It also takes a span back from now, as a number & s, m, h or d. So at=24h reads what was trending on Twitter yesterday at this hour, on every run of a schedule. The answer is the stored list nearest that time, with its own time in capturedAt. History starts 2026-10-13 02:20 UTC. A time over 24 hours from every stored list answers 400 at no charge.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTrends(
        int $count = 30,
        int $woeid = 1,
        ?string $country = null,
        ?string $location = null,
        ?string $at = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): XGetTrendsResponse;

    /**
     * @api
     *
     * @param int|null $woeid WOEID of the place, such as 1 for Worldwide or 23424969 for Turkey. It wins over country & location. /x/trends/locations lists every WOEID.
     * @param string|null $country Country to read trends history for, by name or 2-letter code, such as Turkey or TR. Case insensitive. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     * @param string|null $location Town or country to read trends history for, by name, such as Istanbul. Case insensitive. Add country when 2 towns share a name. /x/trends/locations lists every name. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     * @param string|null $from Start of the range. Takes an ISO 8601 time, a date such as 2026-10-13, or Unix seconds. A time without a zone reads as UTC. It also takes a span back from now, as a number & s, m, h or d, so from=7d reads the last 7 days. Defaults to 24 hours before to. History starts 2026-10-13 02:20 UTC, and a range that begins earlier returns the stored part. Alias sinceTime.
     * @param string|null $to End of the range, which it leaves out. Takes the forms of from, so from=2d with to=1d reads the day before the last 24 hours. Defaults to now. Alias untilTime.
     * @param string|null $every Step between 2 returned lists, as a number & m, h or d, such as 15m, 1h or 1d. A step under 5m returns every stored list.
     * @param int|null $count trends to return in each list
     * @param int|null $limit Maximum lists 1 request returns & charges. A wider range gives a next_cursor for the next lists. A low credit balance can return fewer.
     * @param string|null $cursor The next_cursor of the page before, for the next lists. It keeps the time of the first request, so a range of spans stays the same on every page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTrendsHistory(
        ?int $woeid = null,
        ?string $country = null,
        ?string $location = null,
        ?string $from = null,
        ?string $to = null,
        ?string $every = null,
        ?int $count = null,
        ?int $limit = null,
        ?string $cursor = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): XGetTrendsHistoryResponse;

    /**
     * @api
     *
     * @param string|null $country Country name or 2-letter code, such as Turkey or TR. Case insensitive. Returns the country & its towns. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     * @param PlaceType|value-of<PlaceType>|null $placeType Kind of place. Case insensitive. X labels a few towns unknown.
     * @param string|null $q Text the location name contains, such as york. Case insensitive. Alias query. X can add places, so Xquik takes up to 280 characters, the most a post holds.
     * @param int|null $limit Maximum locations to return. Omit it for every match. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getTrendLocations(
        ?string $country = null,
        PlaceType|string|null $placeType = null,
        ?string $q = null,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): XGetTrendLocationsResponse;

    /**
     * @api
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getNewsStoryVersions(
        string $id,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): XGetNewsStoryVersionsResponse;

    /**
     * @api
     *
     * @param string|null $q Text the hashtag contains, such as football. Case insensitive. A leading hash sign is ignored. Alias query. A post holds at most 280 characters.
     * @param bool|null $activeOnly Keeps hashflags that run now. Send false to add ended & upcoming ones.
     * @param int|null $limit Maximum hashflags to return. Omit it for every match. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function getHashflags(
        ?string $q = null,
        ?bool $activeOnly = null,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): XGetHashflagsResponse;

    /**
     * @api
     *
     * @param string $q Place name to search for, such as istanbul. Alias query. Xquik's cap is 4,096 characters.
     * @param int|null $limit Maximum places to return. Omit it for every place X finds. A low credit balance can return fewer. Aliases pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function searchPlaces(
        string $q,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): XSearchPlacesResponse;

    /**
     * @api
     *
     * @param string $q Text typed so far. Start with # for hashtags or $ for cashtags. A # query returns hashtags & the accounts X suggests for it. Its alias is query. Xquik's cap is 4,096 characters.
     * @param string|null $types Comma-separated suggestion types from users, topics, hashtags & cashtags. Omit for all. With only hashtags or only cashtags, a query without # or $ still works. Any case works. It allows 66 characters for every choice once with spaces around commas.
     * @param int|null $limit Most suggestions to return, from 1 to 100. Default 20. Accounts fill it first, then topics, hashtags & cashtags. A low credit balance can return fewer. Its aliases are pageSize, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function autocompleteSearch(
        string $q,
        ?string $types = null,
        ?int $limit = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): SearchSuggestions;
}
