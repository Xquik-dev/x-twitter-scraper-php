<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Drafts\DraftCreateParams\Goal;
use XTwitterScraper\Drafts\DraftGetResponse;
use XTwitterScraper\Drafts\DraftListResponse;
use XTwitterScraper\Drafts\DraftNewResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\DraftsContract;

/**
 * Tweet composition, drafts, writing styles & radar.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class DraftsService implements DraftsContract
{
    /**
     * @api
     */
    public DraftsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DraftsRawService($client);
    }

    /**
     * @api
     *
     * Save a tweet draft
     *
     * @param Goal|value-of<Goal> $goal
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $text,
        Goal|string|null $goal = null,
        ?string $topic = null,
        RequestOptions|array|null $requestOptions = null,
    ): DraftNewResponse {
        $params = Util::removeNulls(
            ['text' => $text, 'goal' => $goal, 'topic' => $topic]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get draft by ID
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): DraftGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List saved drafts
     *
     * @param string $afterCursor Cursor for pagination
     * @param int $limit Maximum number of items to return (1-100, default 50)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?string $afterCursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): DraftListResponse {
        $params = Util::removeNulls(
            ['afterCursor' => $afterCursor, 'limit' => $limit]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a draft
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($id, requestOptions: $requestOptions);

        return $response->parse();
    }
}
