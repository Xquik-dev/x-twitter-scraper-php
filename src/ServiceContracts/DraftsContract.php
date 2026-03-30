<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Drafts\DraftCreateParams\Goal;
use XTwitterScraper\Drafts\DraftDetail;
use XTwitterScraper\Drafts\DraftListResponse;
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
    ): DraftDetail;

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
    ): DraftDetail;

    /**
     * @api
     *
     * @param string $afterCursor Cursor for pagination
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
