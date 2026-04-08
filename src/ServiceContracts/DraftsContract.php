<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Drafts\DraftCreateParams\Goal;
use XTwitterScraper\Drafts\DraftGetResponse;
use XTwitterScraper\Drafts\DraftListResponse;
use XTwitterScraper\Drafts\DraftNewResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface DraftsContract
{
    /**
     * @api
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
    ): DraftNewResponse;

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
    ): DraftGetResponse;

    /**
     * @api
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
    ): DraftListResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
