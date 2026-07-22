<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\MediaType;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Quotes;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Replies;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Retweets;
use XTwitterScraper\Extractions\ExtractionEstimateCostResponse;
use XTwitterScraper\Extractions\ExtractionExportResultsParams\Format;
use XTwitterScraper\Extractions\ExtractionGetResponse;
use XTwitterScraper\Extractions\ExtractionListParams\Status;
use XTwitterScraper\Extractions\ExtractionListParams\ToolType;
use XTwitterScraper\Extractions\ExtractionListResponse;
use XTwitterScraper\Extractions\ExtractionRunResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ExtractionsContract
{
    /**
     * @api
     *
     * @param string $id Extraction public ID (UUID)
     * @param string $cursor Cursor for keyset pagination from prior response next_cursor
     * @param int $limit Maximum number of results to return (1-1000, default 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $cursor = null,
        int $limit = 100,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionGetResponse;

    /**
     * @api
     *
     * @param string $cursor Cursor for keyset pagination from prior response next_cursor
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
    ): ExtractionListResponse;

    /**
     * @api
     *
     * @param \XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType|value-of<\XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType> $toolType identifier for the extraction tool used to run a job
     * @param string $advancedQuery Raw advanced query string appended to the estimate (tweet_search_extractor)
     * @param string $anyWords Alternative words or quoted phrases for estimated results. Separate with spaces, commas, or lines.
     * @param string $boundingBox Geo bounding box used for estimation, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor)
     * @param string $cashtags cashtags applied to the estimate, separated by spaces, commas, or lines
     * @param string $conversationID Conversation ID filter used for estimation (tweet_search_extractor)
     * @param string $exactPhrase Exact phrase filter for search estimation
     * @param string $excludeWords Words or quoted phrases excluded from estimated results. Separate with spaces, commas, or lines.
     * @param string $fromUser Estimate only tweets from this author username (tweet_search_extractor)
     * @param string $hashtags hashtags applied to the estimate, separated by spaces, commas, or lines
     * @param string $inReplyToTweetID Estimate only replies to this tweet ID (tweet_search_extractor)
     * @param string $language Language code used for estimate filtering (tweet_search_extractor)
     * @param string $listID Estimate search results within this list ID (tweet_search_extractor)
     * @param MediaType|value-of<MediaType> $mediaType Media type used for estimate filtering (tweet_search_extractor)
     * @param string $mentioning Estimate tweets mentioning this username (tweet_search_extractor)
     * @param int $minFaves Minimum likes threshold for estimated results (tweet_search_extractor)
     * @param int $minQuotes Minimum quote count threshold for estimated results (tweet_search_extractor)
     * @param int $minReplies Minimum replies threshold for estimated results (tweet_search_extractor)
     * @param int $minRetweets Minimum retweets threshold for estimated results (tweet_search_extractor)
     * @param string $place Estimate search results within this place ID (tweet_search_extractor)
     * @param string $placeCountry Estimate search results within this country code (tweet_search_extractor)
     * @param string $pointRadius Geo point radius used for estimation, e.g. -73.99 40.73 25mi (tweet_search_extractor)
     * @param Quotes|value-of<Quotes> $quotes Quote mode used for estimation (tweet_search_extractor)
     * @param string $quotesOfTweetID Estimate only quotes of this tweet ID (tweet_search_extractor)
     * @param Replies|value-of<Replies> $replies Reply mode used for estimation (tweet_search_extractor)
     * @param int $resultsLimit Maximum number of results to estimate. When set, the estimate caps projected results to this value.
     * @param Retweets|value-of<Retweets> $retweets Retweet mode used for estimation (tweet_search_extractor)
     * @param string $retweetsOfTweetID Estimate only retweets of this tweet ID (tweet_search_extractor)
     * @param string $searchQuery query used to price tweet_search_extractor or community_search
     * @param string $sinceDate Estimate start date in YYYY-MM-DD format (tweet_search_extractor)
     * @param string $targetCommunityID community ID used to price community_post_extractor or community_search
     * @param string $targetListID list ID used to price list_follower_explorer, list_member_extractor, or list_post_extractor
     * @param string $targetSpaceID space ID used to price space_explorer
     * @param string $toUser Estimate replies sent to this username (tweet_search_extractor)
     * @param string $untilDate Estimate end date in YYYY-MM-DD format (tweet_search_extractor)
     * @param string $url URL substring or domain filter used for estimation (tweet_search_extractor)
     * @param bool $verifiedOnly Estimate only verified authors (tweet_search_extractor)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function estimateCost(
        \XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType|string $toolType,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $boundingBox = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?string $listID = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        ?int $resultsLimit = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $searchQuery = null,
        ?string $sinceDate = null,
        ?string $targetCommunityID = null,
        ?string $targetListID = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?string $targetUsername = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionEstimateCostResponse;

    /**
     * @api
     *
     * @param string $id Extraction public ID
     * @param Format|value-of<Format> $format Export file format
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function exportResults(
        string $id,
        Format|string $format,
        RequestOptions|array|null $requestOptions = null,
    ): string;

    /**
     * @api
     *
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\ToolType|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\ToolType> $toolType identifier for the extraction tool used to run a job
     * @param string $advancedQuery Raw advanced search query appended as-is (tweet_search_extractor)
     * @param string $anyWords Words or quoted phrases where any one can match. Separate with spaces, commas, or lines. (tweet_search_extractor)
     * @param string $boundingBox Geo bounding box, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor)
     * @param string $cashtags Cashtags separated by spaces, commas, or lines. (tweet_search_extractor)
     * @param string $conversationID Conversation ID filter (tweet_search_extractor)
     * @param string $exactPhrase Exact phrase to match (tweet_search_extractor)
     * @param string $excludeWords Words or quoted phrases to exclude. Separate with spaces, commas, or lines. (tweet_search_extractor)
     * @param string $fromUser Filter by author username (tweet_search_extractor)
     * @param string $hashtags Hashtags separated by spaces, commas, or lines. (tweet_search_extractor)
     * @param string $inReplyToTweetID Only replies to this tweet ID (tweet_search_extractor)
     * @param string $language Language code filter (tweet_search_extractor)
     * @param string $listID Search within a list ID (tweet_search_extractor)
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\MediaType|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\MediaType> $mediaType Media type filter (tweet_search_extractor)
     * @param string $mentioning Filter tweets mentioning a username (tweet_search_extractor)
     * @param int $minFaves Minimum likes threshold (tweet_search_extractor)
     * @param int $minQuotes Minimum quote count threshold (tweet_search_extractor)
     * @param int $minReplies Minimum replies threshold (tweet_search_extractor)
     * @param int $minRetweets Minimum retweets threshold (tweet_search_extractor)
     * @param string $place Search within a place ID (tweet_search_extractor)
     * @param string $placeCountry Search within a country code (tweet_search_extractor)
     * @param string $pointRadius Geo point radius, e.g. -73.99 40.73 25mi (tweet_search_extractor)
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Quotes|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Quotes> $quotes Quote mode (tweet_search_extractor)
     * @param string $quotesOfTweetID Only quotes of this tweet ID (tweet_search_extractor)
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Replies|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Replies> $replies Reply mode (tweet_search_extractor)
     * @param int $resultsLimit Maximum number of results to extract. When set, the extraction stops after reaching this limit.
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\Retweets|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\Retweets> $retweets Retweet mode (tweet_search_extractor)
     * @param string $retweetsOfTweetID Only retweets of this tweet ID (tweet_search_extractor)
     * @param string $searchQuery required for tweet_search_extractor & community_search
     * @param string $sinceDate Start date YYYY-MM-DD (tweet_search_extractor)
     * @param string $targetCommunityID required for community_post_extractor & community_search
     * @param string $targetListID required for list_follower_explorer, list_member_extractor & list_post_extractor
     * @param string $targetSpaceID required for space_explorer
     * @param string $toUser Filter replies sent to a username (tweet_search_extractor)
     * @param string $untilDate End date YYYY-MM-DD (tweet_search_extractor)
     * @param string $url URL substring or domain filter (tweet_search_extractor)
     * @param bool $verifiedOnly Only verified authors (tweet_search_extractor)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function run(
        \XTwitterScraper\Extractions\ExtractionRunParams\ToolType|string $toolType,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $boundingBox = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?string $listID = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\Replies|string|null $replies = null,
        ?int $resultsLimit = null,
        \XTwitterScraper\Extractions\ExtractionRunParams\Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $searchQuery = null,
        ?string $sinceDate = null,
        ?string $targetCommunityID = null,
        ?string $targetListID = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?string $targetUsername = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionRunResponse;
}
