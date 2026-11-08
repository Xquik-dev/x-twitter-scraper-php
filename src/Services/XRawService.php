<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedTweets;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\SearchSuggestions;
use XTwitterScraper\ServiceContracts\XRawContract;
use XTwitterScraper\X\XAutocompleteSearchParams;
use XTwitterScraper\X\XGetArticleParams;
use XTwitterScraper\X\XGetArticleResponse;
use XTwitterScraper\X\XGetHashflagsParams;
use XTwitterScraper\X\XGetHashflagsResponse;
use XTwitterScraper\X\XGetHomeTimelineParams;
use XTwitterScraper\X\XGetNewsStoryVersionsParams;
use XTwitterScraper\X\XGetNewsStoryVersionsResponse;
use XTwitterScraper\X\XGetNotificationsParams;
use XTwitterScraper\X\XGetNotificationsParams\Type;
use XTwitterScraper\X\XGetNotificationsResponse;
use XTwitterScraper\X\XGetTrendLocationsParams;
use XTwitterScraper\X\XGetTrendLocationsResponse;
use XTwitterScraper\X\XGetTrendsHistoryParams;
use XTwitterScraper\X\XGetTrendsHistoryResponse;
use XTwitterScraper\X\XGetTrendsParams;
use XTwitterScraper\X\XGetTrendsResponse;
use XTwitterScraper\X\XSearchPlacesParams;
use XTwitterScraper\X\XSearchPlacesResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class XRawService implements XRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Retrieve the full content of an X Article (long-form post) by numeric tweet ID. Returns article_not_found when the tweet is valid but is not an X Article.
     *
     * @param string $tweetID Numeric tweet ID of the article, 15-20 digits. If you have a tweet URL, use the final status ID.
     * @param array<string,mixed>|XGetArticleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetArticleResponse>
     *
     * @throws APIException
     */
    public function getArticle(
        string $tweetID,
        array|XGetArticleParams $params = [],
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = XGetArticleParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/articles/%1$s', $tweetID],
            query: $parsed,
            options: $options,
            convert: XGetArticleResponse::class,
        );
    }

    /**
     * @api
     *
     * Get home timeline
     *
     * @param array{
     *   cursor?: string, seenTweetIDs?: string
     * }|XGetHomeTimelineParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedTweets>
     *
     * @throws APIException
     */
    public function getHomeTimeline(
        array|XGetHomeTimelineParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetHomeTimelineParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/timeline',
            query: Util::array_transform_keys(
                $parsed,
                ['seenTweetIDs' => 'seenTweetIds']
            ),
            options: $options,
            convert: PaginatedTweets::class,
        );
    }

    /**
     * @api
     *
     * Get notifications
     *
     * @param array{
     *   cursor?: string, type?: Type|value-of<Type>
     * }|XGetNotificationsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetNotificationsResponse>
     *
     * @throws APIException
     */
    public function getNotifications(
        array|XGetNotificationsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetNotificationsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/notifications',
            query: $parsed,
            options: $options,
            convert: XGetNotificationsResponse::class,
        );
    }

    /**
     * @api
     *
     * Get trending hashtags and topics from X by region
     *
     * @param array{count?: int, woeid?: int}|XGetTrendsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendsResponse>
     *
     * @throws APIException
     */
    public function getTrends(
        array|XGetTrendsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetTrendsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/trends',
            query: $parsed,
            options: $options,
            convert: XGetTrendsResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the Twitter trends archive of a place, as the lists X showed there over a range of time. Use it for trending on Twitter yesterday, last week or any day since 2026-10-13 02:20 UTC. Xquik stores 1 list per place every 5 minutes and keeps it for 25 months. Pick the place by woeid, country or location name, the range with from & to, and the step with every. from & to take a time or a span back from now, such as 7d, so a schedule can read the last day on every run. Each step returns the first list stored in it, with its own time. Each returned list costs 1 credit, so 24 lists cost 24 credits. A step with no stored list returns none. Empty trend history steps are free. 1 request returns 24 lists, or up to 100 with limit.
     *
     * Trends can be read for any past moment since the archive began.
     *
     * @param array<string,mixed>|XGetTrendsHistoryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendsHistoryResponse>
     *
     * @throws APIException
     */
    public function getTrendsHistory(
        array|XGetTrendsHistoryParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetTrendsHistoryParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/trends/history',
            query: $parsed,
            options: $options,
            convert: XGetTrendsHistoryResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the places X offers trends for. Pass a location's woeid to /x/trends. Each returned location costs 1 credit.
     *
     * @param array<string,mixed>|XGetTrendLocationsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetTrendLocationsResponse>
     *
     * @throws APIException
     */
    public function getTrendLocations(
        array|XGetTrendLocationsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetTrendLocationsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/trends/locations',
            query: $parsed,
            options: $options,
            convert: XGetTrendLocationsResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns each version X wrote of 1 AI news story. Each version has its time, headline & text, oldest first, so you can see how the story changed. Each request costs 1 credit.
     *
     * @param array<string,mixed>|XGetNewsStoryVersionsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetNewsStoryVersionsResponse>
     *
     * @throws APIException
     */
    public function getNewsStoryVersions(
        string $id,
        array|XGetNewsStoryVersionsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetNewsStoryVersionsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/news/%1$s/versions', $id],
            query: $parsed,
            options: $options,
            convert: XGetNewsStoryVersionsResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns X's hashflags, the custom emoji X shows after some hashtags. Lists the ones running now unless activeOnly is false. Each returned hashflag costs 1 credit.
     *
     * @param array<string,mixed>|XGetHashflagsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XGetHashflagsResponse>
     *
     * @throws APIException
     */
    public function getHashflags(
        array|XGetHashflagsParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XGetHashflagsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/hashflags',
            query: $parsed,
            options: $options,
            convert: XGetHashflagsResponse::class,
        );
    }

    /**
     * @api
     *
     * Finds places on X by name. Pass a place's id as place to /x/tweets/search to read posts tagged there. X ranks the places, so their order can differ between requests. Each returned place costs 1 credit.
     *
     * Place searches work with names in 6 languages.
     *
     * @param array<string,mixed>|XSearchPlacesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XSearchPlacesResponse>
     *
     * @throws APIException
     */
    public function searchPlaces(
        array|XSearchPlacesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XSearchPlacesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/places/search',
            query: $parsed,
            options: $options,
            convert: XSearchPlacesResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns the accounts, topics, hashtags & cashtags X suggests while someone types a search. X may rank them differently per request. Costs 1 credit per suggestion.
     *
     * @param array<string,mixed>|XAutocompleteSearchParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SearchSuggestions>
     *
     * @throws APIException
     */
    public function autocompleteSearch(
        array|XAutocompleteSearchParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = XAutocompleteSearchParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'x/search/autocomplete',
            query: $parsed,
            options: $options,
            convert: SearchSuggestions::class,
        );
    }
}
