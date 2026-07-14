<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Draws\DrawExportParams\Format;
use XTwitterScraper\Draws\DrawExportParams\Type;
use XTwitterScraper\Draws\DrawGetResponse;
use XTwitterScraper\Draws\DrawListResponse;
use XTwitterScraper\Draws\DrawRunResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\DrawsContract;

/**
 * Giveaway draws from tweet replies.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class DrawsService implements DrawsContract
{
    /**
     * @api
     */
    public DrawsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DrawsRawService($client);
    }

    /**
     * @api
     *
     * Get draw details
     *
     * @param string $id draw public ID returned by create and list draw responses
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): DrawGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List draws
     *
     * @param string $cursor Cursor for keyset pagination from prior response next_cursor
     * @param int $limit Maximum number of items to return (1-100, default 50). For paid per-result endpoints, the returned count may be lower when remaining credits cannot cover the requested page. If zero paid results are affordable, the endpoint returns 402 insufficient_credits.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): DrawListResponse {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Export draw data
     *
     * @param string $id draw public ID returned by create and list draw responses
     * @param Format|value-of<Format> $format Export output format
     * @param Type|value-of<Type> $type Export winners or all entries
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function export(
        string $id,
        Format|string $format,
        Type|string $type = 'winners',
        RequestOptions|array|null $requestOptions = null,
    ): string {
        $params = Util::removeNulls(['format' => $format, 'type' => $type]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->export($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Runs a giveaway draw from a source tweet. The draw first checks the minimum credits needed to inspect the source tweet and at least one candidate. Remaining credits cap how many replies and retweeters can be inspected before filters and winner selection run.
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
    ): DrawRunResponse {
        $params = Util::removeNulls(
            [
                'tweetURL' => $tweetURL,
                'backupCount' => $backupCount,
                'filterAccountAgeDays' => $filterAccountAgeDays,
                'filterLanguage' => $filterLanguage,
                'filterMinFollowers' => $filterMinFollowers,
                'mustFollowUsername' => $mustFollowUsername,
                'mustRetweet' => $mustRetweet,
                'requiredHashtags' => $requiredHashtags,
                'requiredKeywords' => $requiredKeywords,
                'requiredMentions' => $requiredMentions,
                'uniqueAuthorsOnly' => $uniqueAuthorsOnly,
                'winnerCount' => $winnerCount,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->run(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
