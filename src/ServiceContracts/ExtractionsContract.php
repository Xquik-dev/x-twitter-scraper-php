<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
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
     * @param string $after Cursor for keyset pagination
     * @param int $limit Maximum number of results to return (1-1000, default 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        ?string $after = null,
        int $limit = 100,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionGetResponse;

    /**
     * @api
     *
     * @param string $after Cursor for keyset pagination
     * @param int $limit Maximum number of items to return (1-100, default 50)
     * @param Status|value-of<Status> $status Filter by job status
     * @param ToolType|value-of<ToolType> $toolType Filter by extraction tool type
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $after = null,
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
     * @param string $exactPhrase Exact phrase filter for search estimation
     * @param string $excludeWords Words excluded from estimated search results
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function estimateCost(
        \XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType|string $toolType,
        ?string $advancedQuery = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $searchQuery = null,
        ?string $targetCommunityID = null,
        ?string $targetListID = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?string $targetUsername = null,
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
        Format|string $format = 'csv',
        RequestOptions|array|null $requestOptions = null,
    ): string;

    /**
     * @api
     *
     * @param \XTwitterScraper\Extractions\ExtractionRunParams\ToolType|value-of<\XTwitterScraper\Extractions\ExtractionRunParams\ToolType> $toolType identifier for the extraction tool used to run a job
     * @param string $advancedQuery Raw advanced search query appended as-is (tweet_search_extractor)
     * @param string $exactPhrase Exact phrase to match (tweet_search_extractor)
     * @param string $excludeWords Words to exclude from results (tweet_search_extractor)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function run(
        \XTwitterScraper\Extractions\ExtractionRunParams\ToolType|string $toolType,
        ?string $advancedQuery = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $searchQuery = null,
        ?string $targetCommunityID = null,
        ?string $targetListID = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?string $targetUsername = null,
        RequestOptions|array|null $requestOptions = null,
    ): ExtractionRunResponse;
}
