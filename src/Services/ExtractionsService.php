<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\CollectionStrategy;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\DedupeMode;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\MediaType;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\QueryType;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Quotes;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\RelationTarget;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Replies;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Retweets;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Scope;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Sort;
use XTwitterScraper\Extractions\ExtractionEstimateCostResponse;
use XTwitterScraper\Extractions\ExtractionExportResultsParams\Format;
use XTwitterScraper\Extractions\ExtractionGetResponse;
use XTwitterScraper\Extractions\ExtractionListParams\Status;
use XTwitterScraper\Extractions\ExtractionListParams\ToolType;
use XTwitterScraper\Extractions\ExtractionListResponse;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\FieldStyle;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\OutputMode;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\OutputPreset;
use XTwitterScraper\Extractions\ExtractionRunResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ExtractionsContract;

/**
 * Bulk data extraction (23 tool types).
 *
 * @phpstan-import-type RelationTargetShape from \XTwitterScraper\Extractions\ExtractionEstimateCostParams\RelationTarget
 * @phpstan-import-type SinceTimeShape from \XTwitterScraper\Extractions\ExtractionEstimateCostParams\SinceTime
 * @phpstan-import-type TargetShape from \XTwitterScraper\Extractions\ExtractionEstimateCostParams\Target
 * @phpstan-import-type UntilTimeShape from \XTwitterScraper\Extractions\ExtractionEstimateCostParams\UntilTime
 * @phpstan-import-type RelationTargetShape from \XTwitterScraper\Extractions\ExtractionRunParams\RelationTarget as RelationTargetShape1
 * @phpstan-import-type SinceTimeShape from \XTwitterScraper\Extractions\ExtractionRunParams\SinceTime as SinceTimeShape1
 * @phpstan-import-type TargetShape from \XTwitterScraper\Extractions\ExtractionRunParams\Target as TargetShape1
 * @phpstan-import-type UntilTimeShape from \XTwitterScraper\Extractions\ExtractionRunParams\UntilTime as UntilTimeShape1
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ExtractionsService implements ExtractionsContract
{
    /**
     * @api
     */
    public ExtractionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ExtractionsRawService($client);
    }

    /**
     * @api
     *
     * Get extraction results
     *
     * @param string $id Extraction public ID (UUID)
     * @param string $cursor previous nextCursor
     * @param FieldStyle|value-of<FieldStyle> $fieldStyle preserve source keys or convert result field names
     * @param bool $includeRaw use outputMode=raw instead
     * @param int $limit Maximum number of results to return (1-1000, default 100)
     * @param OutputMode|value-of<OutputMode> $outputMode select compact, full, or raw-compatible result fields
     * @param OutputPreset|value-of<OutputPreset> $outputPreset keep enrichment nested or merge it into each result
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $cursor = null,
        FieldStyle|string $fieldStyle = 'source',
        bool $includeRaw = false,
        int $limit = 100,
        OutputMode|string $outputMode = 'full',
        OutputPreset|string $outputPreset = 'nested',
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionGetResponse {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'fieldStyle' => $fieldStyle,
                'includeRaw' => $includeRaw,
                'limit' => $limit,
                'outputMode' => $outputMode,
                'outputPreset' => $outputPreset,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List extraction jobs
     *
     * @param string $cursor previous nextCursor
     * @param int $limit Maximum number of items to return (1-100, default 50). For paid per-result endpoints, the returned count may be lower when remaining credits cannot cover the requested page. If zero paid results are affordable, the endpoint returns 402 insufficient_credits.
     * @param Status|value-of<Status> $status Filter by job status
     * @param ToolType|value-of<ToolType> $toolType Filter by extraction tool type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        Status|string|null $status = null,
        ToolType|string|null $toolType = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionListResponse {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'limit' => $limit,
                'status' => $status,
                'toolType' => $toolType,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Estimate extraction cost
     *
     * @param \XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType|value-of<\XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType> $toolType identifier for the extraction tool used to run a job
     * @param string $advancedQuery Raw advanced search query appended as-is (tweet_search_extractor)
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines. (tweet_search_extractor)
     * @param string $bioContains bio terms separated by commas or lines
     * @param bool $blueVerifiedOnly return only Blue-verified Tweet authors
     * @param string $boundingBox Geo bounding box, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor)
     * @param string $cardName match the Tweet card name
     * @param string $cashtags Cashtags separated by spaces, commas, or lines. (tweet_search_extractor)
     * @param CollectionStrategy|value-of<CollectionStrategy> $collectionStrategy reply collection strategy
     * @param string $conversationID Conversation ID filter (tweet_search_extractor)
     * @param bool $dedupeAcrossTargets merge duplicate results across collection targets
     * @param DedupeMode|value-of<DedupeMode> $dedupeMode keep target duplicates, first rows, or merged overlap
     * @param string $exactPhrase Exact phrase to match (tweet_search_extractor)
     * @param bool $excludeOriginalAuthor exclude replies from the source author
     * @param string $excludeSource exclude a source application
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines. (tweet_search_extractor)
     * @param string $fromUser Filter by author username (tweet_search_extractor)
     * @param string $geocode match latitude, longitude, and radius
     * @param string $hashtags Hashtags separated by spaces, commas, or lines. (tweet_search_extractor)
     * @param bool $hasLocation require a profile location
     * @param bool $hasMediaOnly return only replies with media
     * @param bool $hasWebsite require a profile website
     * @param bool $includeOriginalPost include the source post in reply results
     * @param bool $includeSearchTerms add matching search terms to collection metadata
     * @param bool $includeTargetMetadata add source target metadata to each result
     * @param string $inReplyToTweetID Only replies to this tweet ID (tweet_search_extractor)
     * @param string $language Language code filter (tweet_search_extractor)
     * @param string $listID Search within a list ID (tweet_search_extractor)
     * @param string $locationContains required profile location text
     * @param int $maxDepth maximum nested reply depth
     * @param int $maxFollowers maximum follower count for profile results
     * @param int $maxFollowing maximum following count for profile results
     * @param string $maxID return Tweets older than this Tweet ID
     * @param int $maxItemsPerTarget maximum results collected for each target
     * @param int $maxLikes maximum Tweet like count
     * @param int $maxPagesPerTarget reply pages collected for each target
     * @param int $maxPosts maximum post count for profile results
     * @param int $maxQuotes maximum Tweet quote count
     * @param int $maxReplies maximum Tweet reply count
     * @param int $maxRetweets maximum Tweet repost count
     * @param MediaType|value-of<MediaType> $mediaType Media type filter (tweet_search_extractor)
     * @param string $mentioning Filter tweets mentioning a username (tweet_search_extractor)
     * @param int $minAccountAgeDays minimum profile age in days
     * @param int $minBookmarks minimum Tweet bookmark count
     * @param int $minFaves Minimum likes threshold (tweet_search_extractor)
     * @param int $minFollowers minimum follower count for profile results
     * @param int $minFollowing minimum following count for profile results
     * @param int $minPosts minimum post count for profile results
     * @param int $minQuotes Minimum quote count threshold (tweet_search_extractor)
     * @param int $minReplies Minimum replies threshold (tweet_search_extractor)
     * @param int $minRetweets Minimum retweets threshold (tweet_search_extractor)
     * @param int $minViews minimum Tweet view count
     * @param bool $nativeRetweets only return native reposts
     * @param string $near match a place name
     * @param bool $news only return news results
     * @param bool $overlapMode shortcut for dedupeMode=merge
     * @param string $place Search within a place ID (tweet_search_extractor)
     * @param string $placeCountry Search within a country code (tweet_search_extractor)
     * @param string $pointRadius Geo point radius, e.g. -73.99 40.73 25mi (tweet_search_extractor)
     * @param QueryType|value-of<QueryType> $queryType search ranking applied to every query
     * @param Quotes|value-of<Quotes> $quotes Quote mode (tweet_search_extractor)
     * @param string $quotesOfTweetID Only quotes of this tweet ID (tweet_search_extractor)
     * @param list<RelationTarget|RelationTargetShape> $relationTargets profile relations processed within one job
     * @param Replies|value-of<Replies> $replies Reply mode (tweet_search_extractor)
     * @param int $resultsLimit Maximum number of results to extract. When set, the extraction stops after reaching this limit.
     * @param Retweets|value-of<Retweets> $retweets Retweet mode (tweet_search_extractor)
     * @param string $retweetsOfTweetID Only retweets of this tweet ID (tweet_search_extractor)
     * @param bool $safe enable the safe-search filter
     * @param Scope|value-of<Scope> $scope reply depth scope
     * @param list<string> $searchQueries search queries processed as one collection job
     * @param string $searchQuery required for tweet_search_extractor & community_search
     * @param string $sinceDate Start date YYYY-MM-DD (tweet_search_extractor)
     * @param string $sinceID return Tweets newer than this Tweet ID
     * @param SinceTimeShape $sinceTime reply start time as ISO 8601 or Unix seconds
     * @param Sort|value-of<Sort> $sort reply result order
     * @param string $source match the source application
     * @param string $startCursor resume one reply target from this cursor
     * @param string $targetCommunityID required for community_post_extractor & community_search
     * @param list<string> $targetCommunityIDs community IDs processed as one collection job
     * @param string $targetListID required for list_follower_explorer, list_member_extractor & list_post_extractor
     * @param list<string> $targetListIDs list IDs processed as one collection job
     * @param list<TargetShape> $targets mixed targets auto-routed within one job
     * @param string $targetSpaceID required for space_explorer
     * @param list<string> $targetTweetIDs tweet IDs processed as one collection job
     * @param list<string> $targetUsernames usernames processed as one collection job
     * @param string $toUser Filter replies sent to a username (tweet_search_extractor)
     * @param string $untilDate End date YYYY-MM-DD (tweet_search_extractor)
     * @param UntilTimeShape $untilTime reply end time as ISO 8601 or Unix seconds
     * @param string $url URL substring or domain filter (tweet_search_extractor)
     * @param string $usernameContains required username text
     * @param bool $verifiedOnly Only verified authors (tweet_search_extractor)
     * @param string $verifiedType exact profile verification type
     * @param string $within set the radius for the near filter
     * @param string $withinTime match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function estimateCost(
        \XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType|string $toolType,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $bioContains = null,
        bool $blueVerifiedOnly = false,
        ?string $boundingBox = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        CollectionStrategy|string $collectionStrategy = 'auto',
        ?string $conversationID = null,
        bool $dedupeAcrossTargets = true,
        DedupeMode|string|null $dedupeMode = null,
        ?string $exactPhrase = null,
        bool $excludeOriginalAuthor = false,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        bool $hasLocation = false,
        bool $hasMediaOnly = false,
        bool $hasWebsite = false,
        bool $includeOriginalPost = false,
        bool $includeSearchTerms = false,
        bool $includeTargetMetadata = true,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?string $listID = null,
        ?string $locationContains = null,
        ?int $maxDepth = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?string $maxID = null,
        ?int $maxItemsPerTarget = null,
        ?int $maxLikes = null,
        ?int $maxPagesPerTarget = null,
        ?int $maxPosts = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minAccountAgeDays = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minPosts = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        bool $nativeRetweets = false,
        ?string $near = null,
        bool $news = false,
        bool $overlapMode = false,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        QueryType|string $queryType = 'Latest',
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        ?array $relationTargets = null,
        Replies|string|null $replies = null,
        ?int $resultsLimit = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        bool $safe = false,
        Scope|string $scope = 'all',
        ?array $searchQueries = null,
        ?string $searchQuery = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        int|\DateTimeInterface|null $sinceTime = null,
        Sort|string $sort = 'relevance',
        ?string $source = null,
        ?string $startCursor = null,
        ?string $targetCommunityID = null,
        ?array $targetCommunityIDs = null,
        ?string $targetListID = null,
        ?array $targetListIDs = null,
        ?array $targets = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?array $targetTweetIDs = null,
        ?string $targetUsername = null,
        ?array $targetUsernames = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        int|\DateTimeInterface|null $untilTime = null,
        ?string $url = null,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionEstimateCostResponse {
        $params = Util::removeNulls(
            [
                'toolType' => $toolType,
                'advancedQuery' => $advancedQuery,
                'anyWords' => $anyWords,
                'bioContains' => $bioContains,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'boundingBox' => $boundingBox,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'collectionStrategy' => $collectionStrategy,
                'conversationID' => $conversationID,
                'dedupeAcrossTargets' => $dedupeAcrossTargets,
                'dedupeMode' => $dedupeMode,
                'exactPhrase' => $exactPhrase,
                'excludeOriginalAuthor' => $excludeOriginalAuthor,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'hasLocation' => $hasLocation,
                'hasMediaOnly' => $hasMediaOnly,
                'hasWebsite' => $hasWebsite,
                'includeOriginalPost' => $includeOriginalPost,
                'includeSearchTerms' => $includeSearchTerms,
                'includeTargetMetadata' => $includeTargetMetadata,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'listID' => $listID,
                'locationContains' => $locationContains,
                'maxDepth' => $maxDepth,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxID' => $maxID,
                'maxItemsPerTarget' => $maxItemsPerTarget,
                'maxLikes' => $maxLikes,
                'maxPagesPerTarget' => $maxPagesPerTarget,
                'maxPosts' => $maxPosts,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minPosts' => $minPosts,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'overlapMode' => $overlapMode,
                'place' => $place,
                'placeCountry' => $placeCountry,
                'pointRadius' => $pointRadius,
                'queryType' => $queryType,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'relationTargets' => $relationTargets,
                'replies' => $replies,
                'resultsLimit' => $resultsLimit,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'scope' => $scope,
                'searchQueries' => $searchQueries,
                'searchQuery' => $searchQuery,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'sinceTime' => $sinceTime,
                'sort' => $sort,
                'source' => $source,
                'startCursor' => $startCursor,
                'targetCommunityID' => $targetCommunityID,
                'targetCommunityIDs' => $targetCommunityIDs,
                'targetListID' => $targetListID,
                'targetListIDs' => $targetListIDs,
                'targets' => $targets,
                'targetSpaceID' => $targetSpaceID,
                'targetTweetID' => $targetTweetID,
                'targetTweetIDs' => $targetTweetIDs,
                'targetUsername' => $targetUsername,
                'targetUsernames' => $targetUsernames,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->estimateCost(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Export extraction results
     *
     * @param string $id Extraction public ID
     * @param Format|value-of<Format> $format Export file format
     * @param bool $hasDescription require a non-empty description
     * @param bool $hasLocation require a non-empty location
     * @param bool $hasMedia require media
     * @param string $lang filter by language code
     * @param int $maxFollowers maximum follower count
     * @param int $maxFollowing maximum following count
     * @param int $maxPosts maximum post count
     * @param int $minFollowers minimum follower count
     * @param int $minFollowing minimum following count
     * @param int $minLikes minimum like count
     * @param int $minPosts minimum post count
     * @param int $minReplies minimum reply count
     * @param int $minRetweets minimum repost count
     * @param int $minViews minimum view count
     * @param string $search search exported result text
     * @param string $sinceDate include results on or after this date
     * @param string $untilDate include results on or before this date
     * @param bool $verified filter by verified status
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function exportResults(
        string $id,
        Format|string $format,
        ?bool $hasDescription = null,
        ?bool $hasLocation = null,
        ?bool $hasMedia = null,
        ?string $lang = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxPosts = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minLikes = null,
        ?int $minPosts = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?string $search = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        ?bool $verified = null,
        RequestOptions|array|null $requestOptions = null,
    ): string {
        $params = Util::removeNulls(
            [
                'format' => $format,
                'hasDescription' => $hasDescription,
                'hasLocation' => $hasLocation,
                'hasMedia' => $hasMedia,
                'lang' => $lang,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxPosts' => $maxPosts,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minLikes' => $minLikes,
                'minPosts' => $minPosts,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'search' => $search,
                'sinceDate' => $sinceDate,
                'untilDate' => $untilDate,
                'verified' => $verified,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->exportResults($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Run extraction
     *
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\ToolType|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\ToolType> $toolType body param: Identifier for the extraction tool used to run a job
     * @param bool $dryRun query param: Estimate cost without creating an extraction
     * @param string $advancedQuery Body param: Raw advanced search query appended as-is (tweet_search_extractor)
     * @param string $anyWords Body param: Words or quoted phrases where any one can match. Separate with spaces, commas, or lines. (tweet_search_extractor)
     * @param string $bioContains body param: Bio terms separated by commas or lines
     * @param bool $blueVerifiedOnly body param: Return only Blue-verified Tweet authors
     * @param string $boundingBox Body param: Geo bounding box, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor)
     * @param string $cardName body param: Match the Tweet card name
     * @param string $cashtags Body param: Cashtags separated by spaces, commas, or lines. (tweet_search_extractor)
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\CollectionStrategy|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\CollectionStrategy> $collectionStrategy body param: Reply collection strategy
     * @param string $conversationID Body param: Conversation ID filter (tweet_search_extractor)
     * @param bool $dedupeAcrossTargets body param: Merge duplicate results across collection targets
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\DedupeMode|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\DedupeMode> $dedupeMode body param: Keep target duplicates, first rows, or merged overlap
     * @param string $exactPhrase Body param: Exact phrase to match (tweet_search_extractor)
     * @param bool $excludeOriginalAuthor body param: Exclude replies from the source author
     * @param string $excludeSource body param: Exclude a source application
     * @param string $excludeWords Body param: Words or quoted phrases to exclude. Separate with spaces, commas, or lines. (tweet_search_extractor)
     * @param string $fromUser Body param: Filter by author username (tweet_search_extractor)
     * @param string $geocode body param: Match latitude, longitude, and radius
     * @param string $hashtags Body param: Hashtags separated by spaces, commas, or lines. (tweet_search_extractor)
     * @param bool $hasLocation body param: Require a profile location
     * @param bool $hasMediaOnly body param: Return only replies with media
     * @param bool $hasWebsite body param: Require a profile website
     * @param bool $includeOriginalPost body param: Include the source post in reply results
     * @param bool $includeSearchTerms body param: Add matching search terms to collection metadata
     * @param bool $includeTargetMetadata body param: Add source target metadata to each result
     * @param string $inReplyToTweetID Body param: Only replies to this tweet ID (tweet_search_extractor)
     * @param string $language Body param: Language code filter (tweet_search_extractor)
     * @param string $listID Body param: Search within a list ID (tweet_search_extractor)
     * @param string $locationContains body param: Required profile location text
     * @param int $maxDepth body param: Maximum nested reply depth
     * @param int $maxFollowers body param: Maximum follower count for profile results
     * @param int $maxFollowing body param: Maximum following count for profile results
     * @param string $maxID body param: Return Tweets older than this Tweet ID
     * @param int $maxItemsPerTarget body param: Maximum results collected for each target
     * @param int $maxLikes body param: Maximum Tweet like count
     * @param int $maxPagesPerTarget body param: Reply pages collected for each target
     * @param int $maxPosts body param: Maximum post count for profile results
     * @param int $maxQuotes body param: Maximum Tweet quote count
     * @param int $maxReplies body param: Maximum Tweet reply count
     * @param int $maxRetweets body param: Maximum Tweet repost count
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\MediaType|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\MediaType> $mediaType Body param: Media type filter (tweet_search_extractor)
     * @param string $mentioning Body param: Filter tweets mentioning a username (tweet_search_extractor)
     * @param int $minAccountAgeDays body param: Minimum profile age in days
     * @param int $minBookmarks body param: Minimum Tweet bookmark count
     * @param int $minFaves Body param: Minimum likes threshold (tweet_search_extractor)
     * @param int $minFollowers body param: Minimum follower count for profile results
     * @param int $minFollowing body param: Minimum following count for profile results
     * @param int $minPosts body param: Minimum post count for profile results
     * @param int $minQuotes Body param: Minimum quote count threshold (tweet_search_extractor)
     * @param int $minReplies Body param: Minimum replies threshold (tweet_search_extractor)
     * @param int $minRetweets Body param: Minimum retweets threshold (tweet_search_extractor)
     * @param int $minViews body param: Minimum Tweet view count
     * @param bool $nativeRetweets body param: Only return native reposts
     * @param string $near body param: Match a place name
     * @param bool $news body param: Only return news results
     * @param bool $overlapMode body param: Shortcut for dedupeMode=merge
     * @param string $place Body param: Search within a place ID (tweet_search_extractor)
     * @param string $placeCountry Body param: Search within a country code (tweet_search_extractor)
     * @param string $pointRadius Body param: Geo point radius, e.g. -73.99 40.73 25mi (tweet_search_extractor)
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\QueryType|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\QueryType> $queryType body param: Search ranking applied to every query
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Quotes|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Quotes> $quotes Body param: Quote mode (tweet_search_extractor)
     * @param string $quotesOfTweetID Body param: Only quotes of this tweet ID (tweet_search_extractor)
     * @param list<\XTwitterScraper\Extractions\ExtractionRunParams\RelationTarget|RelationTargetShape1> $relationTargets body param: Profile relations processed within one job
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Replies|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Replies> $replies Body param: Reply mode (tweet_search_extractor)
     * @param int $resultsLimit Body param: Maximum number of results to extract. When set, the extraction stops after reaching this limit.
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Retweets|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Retweets> $retweets Body param: Retweet mode (tweet_search_extractor)
     * @param string $retweetsOfTweetID Body param: Only retweets of this tweet ID (tweet_search_extractor)
     * @param bool $safe body param: Enable the safe-search filter
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Scope|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Scope> $scope body param: Reply depth scope
     * @param list<string> $searchQueries body param: Search queries processed as one collection job
     * @param string $searchQuery body param: Required for tweet_search_extractor & community_search
     * @param string $sinceDate Body param: Start date YYYY-MM-DD (tweet_search_extractor)
     * @param string $sinceID body param: Return Tweets newer than this Tweet ID
     * @param SinceTimeShape1 $sinceTime body param: Reply start time as ISO 8601 or Unix seconds
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Sort|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Sort> $sort body param: Reply result order
     * @param string $source body param: Match the source application
     * @param string $startCursor body param: Resume one reply target from this cursor
     * @param string $targetCommunityID body param: Required for community_post_extractor & community_search
     * @param list<string> $targetCommunityIDs body param: Community IDs processed as one collection job
     * @param string $targetListID body param: Required for list_follower_explorer, list_member_extractor & list_post_extractor
     * @param list<string> $targetListIDs body param: List IDs processed as one collection job
     * @param list<TargetShape1> $targets body param: Mixed targets auto-routed within one job
     * @param string $targetSpaceID body param: Required for space_explorer
     * @param string $targetTweetID Body param
     * @param list<string> $targetTweetIDs body param: Tweet IDs processed as one collection job
     * @param string $targetUsername Body param
     * @param list<string> $targetUsernames body param: Usernames processed as one collection job
     * @param string $toUser Body param: Filter replies sent to a username (tweet_search_extractor)
     * @param string $untilDate Body param: End date YYYY-MM-DD (tweet_search_extractor)
     * @param UntilTimeShape1 $untilTime body param: Reply end time as ISO 8601 or Unix seconds
     * @param string $url Body param: URL substring or domain filter (tweet_search_extractor)
     * @param string $usernameContains body param: Required username text
     * @param bool $verifiedOnly Body param: Only verified authors (tweet_search_extractor)
     * @param string $verifiedType body param: Exact profile verification type
     * @param string $within body param: Set the radius for the near filter
     * @param string $withinTime body param: Match Tweets inside a recent time window
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function run(
        \XTwitterScraper\Extractions\ExtractionRunParams\ToolType|string $toolType,
        bool $dryRun = false,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $bioContains = null,
        bool $blueVerifiedOnly = false,
        ?string $boundingBox = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\CollectionStrategy|string $collectionStrategy = 'auto',
        ?string $conversationID = null,
        bool $dedupeAcrossTargets = true,
        \XTwitterScraper\Extractions\ExtractionRunParams\DedupeMode|string|null $dedupeMode = null,
        ?string $exactPhrase = null,
        bool $excludeOriginalAuthor = false,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        bool $hasLocation = false,
        bool $hasMediaOnly = false,
        bool $hasWebsite = false,
        bool $includeOriginalPost = false,
        bool $includeSearchTerms = false,
        bool $includeTargetMetadata = true,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?string $listID = null,
        ?string $locationContains = null,
        ?int $maxDepth = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?string $maxID = null,
        ?int $maxItemsPerTarget = null,
        ?int $maxLikes = null,
        ?int $maxPagesPerTarget = null,
        ?int $maxPosts = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minAccountAgeDays = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minPosts = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        bool $nativeRetweets = false,
        ?string $near = null,
        bool $news = false,
        bool $overlapMode = false,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\QueryType|string $queryType = 'Latest',
        \XTwitterScraper\Extractions\ExtractionRunParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        ?array $relationTargets = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\Replies|string|null $replies = null,
        ?int $resultsLimit = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        bool $safe = false,
        \XTwitterScraper\Extractions\ExtractionRunParams\Scope|string $scope = 'all',
        ?array $searchQueries = null,
        ?string $searchQuery = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        int|\DateTimeInterface|null $sinceTime = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\Sort|string $sort = 'relevance',
        ?string $source = null,
        ?string $startCursor = null,
        ?string $targetCommunityID = null,
        ?array $targetCommunityIDs = null,
        ?string $targetListID = null,
        ?array $targetListIDs = null,
        ?array $targets = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?array $targetTweetIDs = null,
        ?string $targetUsername = null,
        ?array $targetUsernames = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        int|\DateTimeInterface|null $untilTime = null,
        ?string $url = null,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        ?string $within = null,
        ?string $withinTime = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionRunResponse {
        $params = Util::removeNulls(
            [
                'toolType' => $toolType,
                'dryRun' => $dryRun,
                'advancedQuery' => $advancedQuery,
                'anyWords' => $anyWords,
                'bioContains' => $bioContains,
                'blueVerifiedOnly' => $blueVerifiedOnly,
                'boundingBox' => $boundingBox,
                'cardName' => $cardName,
                'cashtags' => $cashtags,
                'collectionStrategy' => $collectionStrategy,
                'conversationID' => $conversationID,
                'dedupeAcrossTargets' => $dedupeAcrossTargets,
                'dedupeMode' => $dedupeMode,
                'exactPhrase' => $exactPhrase,
                'excludeOriginalAuthor' => $excludeOriginalAuthor,
                'excludeSource' => $excludeSource,
                'excludeWords' => $excludeWords,
                'fromUser' => $fromUser,
                'geocode' => $geocode,
                'hashtags' => $hashtags,
                'hasLocation' => $hasLocation,
                'hasMediaOnly' => $hasMediaOnly,
                'hasWebsite' => $hasWebsite,
                'includeOriginalPost' => $includeOriginalPost,
                'includeSearchTerms' => $includeSearchTerms,
                'includeTargetMetadata' => $includeTargetMetadata,
                'inReplyToTweetID' => $inReplyToTweetID,
                'language' => $language,
                'listID' => $listID,
                'locationContains' => $locationContains,
                'maxDepth' => $maxDepth,
                'maxFollowers' => $maxFollowers,
                'maxFollowing' => $maxFollowing,
                'maxID' => $maxID,
                'maxItemsPerTarget' => $maxItemsPerTarget,
                'maxLikes' => $maxLikes,
                'maxPagesPerTarget' => $maxPagesPerTarget,
                'maxPosts' => $maxPosts,
                'maxQuotes' => $maxQuotes,
                'maxReplies' => $maxReplies,
                'maxRetweets' => $maxRetweets,
                'mediaType' => $mediaType,
                'mentioning' => $mentioning,
                'minAccountAgeDays' => $minAccountAgeDays,
                'minBookmarks' => $minBookmarks,
                'minFaves' => $minFaves,
                'minFollowers' => $minFollowers,
                'minFollowing' => $minFollowing,
                'minPosts' => $minPosts,
                'minQuotes' => $minQuotes,
                'minReplies' => $minReplies,
                'minRetweets' => $minRetweets,
                'minViews' => $minViews,
                'nativeRetweets' => $nativeRetweets,
                'near' => $near,
                'news' => $news,
                'overlapMode' => $overlapMode,
                'place' => $place,
                'placeCountry' => $placeCountry,
                'pointRadius' => $pointRadius,
                'queryType' => $queryType,
                'quotes' => $quotes,
                'quotesOfTweetID' => $quotesOfTweetID,
                'relationTargets' => $relationTargets,
                'replies' => $replies,
                'resultsLimit' => $resultsLimit,
                'retweets' => $retweets,
                'retweetsOfTweetID' => $retweetsOfTweetID,
                'safe' => $safe,
                'scope' => $scope,
                'searchQueries' => $searchQueries,
                'searchQuery' => $searchQuery,
                'sinceDate' => $sinceDate,
                'sinceID' => $sinceID,
                'sinceTime' => $sinceTime,
                'sort' => $sort,
                'source' => $source,
                'startCursor' => $startCursor,
                'targetCommunityID' => $targetCommunityID,
                'targetCommunityIDs' => $targetCommunityIDs,
                'targetListID' => $targetListID,
                'targetListIDs' => $targetListIDs,
                'targets' => $targets,
                'targetSpaceID' => $targetSpaceID,
                'targetTweetID' => $targetTweetID,
                'targetTweetIDs' => $targetTweetIDs,
                'targetUsername' => $targetUsername,
                'targetUsernames' => $targetUsernames,
                'toUser' => $toUser,
                'untilDate' => $untilDate,
                'untilTime' => $untilTime,
                'url' => $url,
                'usernameContains' => $usernameContains,
                'verifiedOnly' => $verifiedOnly,
                'verifiedType' => $verifiedType,
                'within' => $within,
                'withinTime' => $withinTime,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->run(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
