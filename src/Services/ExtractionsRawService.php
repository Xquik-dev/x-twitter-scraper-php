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
use XTwitterScraper\Extractions\ExtractionEstimateCostParams;
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
use XTwitterScraper\Extractions\ExtractionExportResultsParams;
use XTwitterScraper\Extractions\ExtractionExportResultsParams\Format;
use XTwitterScraper\Extractions\ExtractionGetResponse;
use XTwitterScraper\Extractions\ExtractionListParams;
use XTwitterScraper\Extractions\ExtractionListParams\Status;
use XTwitterScraper\Extractions\ExtractionListParams\ToolType;
use XTwitterScraper\Extractions\ExtractionListResponse;
use XTwitterScraper\Extractions\ExtractionRetrieveParams;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\FieldStyle;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\OutputMode;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\OutputPreset;
use XTwitterScraper\Extractions\ExtractionRunParams;
use XTwitterScraper\Extractions\ExtractionRunResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\ExtractionsRawContract;

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
final class ExtractionsRawService implements ExtractionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get extraction results
     *
     * @param string $id Extraction public ID (UUID)
     * @param array{
     *   cursor?: string,
     *   fieldStyle?: FieldStyle|value-of<FieldStyle>,
     *   includeRaw?: bool,
     *   limit?: int,
     *   outputMode?: OutputMode|value-of<OutputMode>,
     *   outputPreset?: OutputPreset|value-of<OutputPreset>,
     * }|ExtractionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        array|ExtractionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['extractions/%1$s', $id],
            query: $parsed,
            options: $options,
            convert: ExtractionGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List extraction jobs
     *
     * @param array{
     *   cursor?: string,
     *   limit?: int,
     *   status?: Status|value-of<Status>,
     *   toolType?: value-of<ToolType>,
     * }|ExtractionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|ExtractionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'extractions',
            query: $parsed,
            options: $options,
            convert: ExtractionListResponse::class,
        );
    }

    /**
     * @api
     *
     * Estimate extraction cost
     *
     * @param array{
     *   toolType: value-of<ExtractionEstimateCostParams\ToolType>,
     *   advancedQuery?: string,
     *   anyWords?: string,
     *   bioContains?: string,
     *   blueVerifiedOnly?: bool,
     *   boundingBox?: string,
     *   cardName?: string,
     *   cashtags?: string,
     *   collectionStrategy?: CollectionStrategy|value-of<CollectionStrategy>,
     *   conversationID?: string,
     *   dedupeAcrossTargets?: bool,
     *   dedupeMode?: DedupeMode|value-of<DedupeMode>,
     *   exactPhrase?: string,
     *   excludeOriginalAuthor?: bool,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   hasLocation?: bool,
     *   hasMediaOnly?: bool,
     *   hasWebsite?: bool,
     *   includeOriginalPost?: bool,
     *   includeSearchTerms?: bool,
     *   includeTargetMetadata?: bool,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   listID?: string,
     *   locationContains?: string,
     *   maxDepth?: int,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxID?: string,
     *   maxItemsPerTarget?: int,
     *   maxLikes?: int,
     *   maxPagesPerTarget?: int,
     *   maxPosts?: int,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: MediaType|value-of<MediaType>,
     *   mentioning?: string,
     *   minAccountAgeDays?: int,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minPosts?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   overlapMode?: bool,
     *   place?: string,
     *   placeCountry?: string,
     *   pointRadius?: string,
     *   queryType?: QueryType|value-of<QueryType>,
     *   quotes?: Quotes|value-of<Quotes>,
     *   quotesOfTweetID?: string,
     *   relationTargets?: list<RelationTarget|RelationTargetShape>,
     *   replies?: Replies|value-of<Replies>,
     *   resultsLimit?: int,
     *   retweets?: Retweets|value-of<Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   scope?: Scope|value-of<Scope>,
     *   searchQueries?: list<string>,
     *   searchQuery?: string,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   sinceTime?: SinceTimeShape,
     *   sort?: Sort|value-of<Sort>,
     *   source?: string,
     *   startCursor?: string,
     *   targetCommunityID?: string,
     *   targetCommunityIDs?: list<string>,
     *   targetListID?: string,
     *   targetListIDs?: list<string>,
     *   targets?: list<TargetShape>,
     *   targetSpaceID?: string,
     *   targetTweetID?: string,
     *   targetTweetIDs?: list<string>,
     *   targetUsername?: string,
     *   targetUsernames?: list<string>,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: UntilTimeShape,
     *   url?: string,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     *   within?: string,
     *   withinTime?: string,
     * }|ExtractionEstimateCostParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionEstimateCostResponse>
     *
     * @throws APIException
     */
    public function estimateCost(
        array|ExtractionEstimateCostParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionEstimateCostParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'extractions/estimate',
            body: (object) $parsed,
            options: $options,
            convert: ExtractionEstimateCostResponse::class,
        );
    }

    /**
     * @api
     *
     * Export extraction results
     *
     * @param string $id Extraction public ID
     * @param array{
     *   format: Format|value-of<Format>,
     *   hasDescription?: bool,
     *   hasLocation?: bool,
     *   hasMedia?: bool,
     *   lang?: string,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxPosts?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minLikes?: int,
     *   minPosts?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   search?: string,
     *   sinceDate?: string,
     *   untilDate?: string,
     *   verified?: bool,
     * }|ExtractionExportResultsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function exportResults(
        string $id,
        array|ExtractionExportResultsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionExportResultsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['extractions/%1$s/export', $id],
            query: $parsed,
            headers: ['Accept' => 'application/octet-stream'],
            options: $options,
            convert: 'string',
        );
    }

    /**
     * @api
     *
     * Run extraction
     *
     * @param array{
     *   toolType: value-of<ExtractionRunParams\ToolType>,
     *   dryRun?: bool,
     *   advancedQuery?: string,
     *   anyWords?: string,
     *   bioContains?: string,
     *   blueVerifiedOnly?: bool,
     *   boundingBox?: string,
     *   cardName?: string,
     *   cashtags?: string,
     *   collectionStrategy?: ExtractionRunParams\CollectionStrategy|value-of<ExtractionRunParams\CollectionStrategy>,
     *   conversationID?: string,
     *   dedupeAcrossTargets?: bool,
     *   dedupeMode?: ExtractionRunParams\DedupeMode|value-of<ExtractionRunParams\DedupeMode>,
     *   exactPhrase?: string,
     *   excludeOriginalAuthor?: bool,
     *   excludeSource?: string,
     *   excludeWords?: string,
     *   fromUser?: string,
     *   geocode?: string,
     *   hashtags?: string,
     *   hasLocation?: bool,
     *   hasMediaOnly?: bool,
     *   hasWebsite?: bool,
     *   includeOriginalPost?: bool,
     *   includeSearchTerms?: bool,
     *   includeTargetMetadata?: bool,
     *   inReplyToTweetID?: string,
     *   language?: string,
     *   listID?: string,
     *   locationContains?: string,
     *   maxDepth?: int,
     *   maxFollowers?: int,
     *   maxFollowing?: int,
     *   maxID?: string,
     *   maxItemsPerTarget?: int,
     *   maxLikes?: int,
     *   maxPagesPerTarget?: int,
     *   maxPosts?: int,
     *   maxQuotes?: int,
     *   maxReplies?: int,
     *   maxRetweets?: int,
     *   mediaType?: ExtractionRunParams\MediaType|value-of<ExtractionRunParams\MediaType>,
     *   mentioning?: string,
     *   minAccountAgeDays?: int,
     *   minBookmarks?: int,
     *   minFaves?: int,
     *   minFollowers?: int,
     *   minFollowing?: int,
     *   minPosts?: int,
     *   minQuotes?: int,
     *   minReplies?: int,
     *   minRetweets?: int,
     *   minViews?: int,
     *   nativeRetweets?: bool,
     *   near?: string,
     *   news?: bool,
     *   overlapMode?: bool,
     *   place?: string,
     *   placeCountry?: string,
     *   pointRadius?: string,
     *   queryType?: ExtractionRunParams\QueryType|value-of<ExtractionRunParams\QueryType>,
     *   quotes?: ExtractionRunParams\Quotes|value-of<ExtractionRunParams\Quotes>,
     *   quotesOfTweetID?: string,
     *   relationTargets?: list<ExtractionRunParams\RelationTarget|RelationTargetShape1>,
     *   replies?: ExtractionRunParams\Replies|value-of<ExtractionRunParams\Replies>,
     *   resultsLimit?: int,
     *   retweets?: ExtractionRunParams\Retweets|value-of<ExtractionRunParams\Retweets>,
     *   retweetsOfTweetID?: string,
     *   safe?: bool,
     *   scope?: ExtractionRunParams\Scope|value-of<ExtractionRunParams\Scope>,
     *   searchQueries?: list<string>,
     *   searchQuery?: string,
     *   sinceDate?: string,
     *   sinceID?: string,
     *   sinceTime?: SinceTimeShape1,
     *   sort?: ExtractionRunParams\Sort|value-of<ExtractionRunParams\Sort>,
     *   source?: string,
     *   startCursor?: string,
     *   targetCommunityID?: string,
     *   targetCommunityIDs?: list<string>,
     *   targetListID?: string,
     *   targetListIDs?: list<string>,
     *   targets?: list<TargetShape1>,
     *   targetSpaceID?: string,
     *   targetTweetID?: string,
     *   targetTweetIDs?: list<string>,
     *   targetUsername?: string,
     *   targetUsernames?: list<string>,
     *   toUser?: string,
     *   untilDate?: string,
     *   untilTime?: UntilTimeShape1,
     *   url?: string,
     *   usernameContains?: string,
     *   verifiedOnly?: bool,
     *   verifiedType?: string,
     *   within?: string,
     *   withinTime?: string,
     * }|ExtractionRunParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExtractionRunResponse>
     *
     * @throws APIException
     */
    public function run(
        array|ExtractionRunParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExtractionRunParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['dryRun']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'extractions',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['dryRun' => 'dry_run']
            ),
            body: (object) array_diff_key($parsed, $query_params),
            options: $options,
            convert: ExtractionRunResponse::class,
        );
    }
}
