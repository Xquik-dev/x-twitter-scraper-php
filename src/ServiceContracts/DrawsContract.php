<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Draws\DrawExportParams\Format;
use XTwitterScraper\Draws\DrawExportParams\Type;
use XTwitterScraper\Draws\DrawGetResponse;
use XTwitterScraper\Draws\DrawListResponse;
use XTwitterScraper\Draws\DrawRunResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface DrawsContract
{
    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): DrawGetResponse;

    /**
     * @api
     *
     * @param string $after Cursor for pagination
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $after = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): DrawListResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param Format|value-of<Format> $format
     * @param Type|value-of<Type> $type Export winners or all entries
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function export(
        string $id,
        Format|string $format = 'csv',
        Type|string $type = 'winners',
        RequestOptions|array|null $requestOptions = null,
    ): string;

    /**
     * @api
     *
     * @param list<string> $requiredHashtags
     * @param list<string> $requiredKeywords
     * @param list<string> $requiredMentions
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function run(
        string $tweetURL,
        ?int $backupCount = null,
        ?int $filterAccountAgeDays = null,
        ?string $filterLanguage = null,
        ?int $filterMinFollowers = null,
        ?string $mustFollowUsername = null,
        ?bool $mustRetweet = null,
        ?array $requiredHashtags = null,
        ?array $requiredKeywords = null,
        ?array $requiredMentions = null,
        ?bool $uniqueAuthorsOnly = null,
        int $winnerCount = 1,
        RequestOptions|array|null $requestOptions = null,
    ): DrawRunResponse;
}
