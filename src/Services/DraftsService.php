<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\Drafts\DraftCreateParams\Goal;
use XTwitterScraper\Drafts\DraftDetail;
use XTwitterScraper\Drafts\DraftListResponse;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\DraftsContract;

/**
 * AI tweet composition, drafts, writing styles, and radar.
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
    ): DraftDetail {
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
     * @param string $id resource ID returned by the matching create or list endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): DraftDetail {
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
     * @param int $limit Maximum number of items to return (1-100, default 50). For paid per-result endpoints, the returned count may be lower when remaining credits cannot cover the requested page. If zero paid results are affordable, the endpoint returns 402 insufficient_credits.
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
     * @param string $id resource ID returned by the matching create or list endpoint
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
