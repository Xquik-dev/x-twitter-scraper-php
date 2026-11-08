<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\PaginatedCommunityNotes;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\CommunityNotesContract;
use XTwitterScraper\X\CommunityNotes\CommunityNoteRetrieveContributorResponse;

/**
 * CommunityNote operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class CommunityNotesService implements CommunityNotesContract
{
    /**
     * @api
     */
    public CommunityNotesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new CommunityNotesRawService($client);
    }

    /**
     * @api
     *
     * Returns 1 Community Notes contributor by the alias X gives them. Includes note counts by rating, rating counts & the deleted notes count. Each lookup costs 1 credit.
     *
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveContributor(
        string $alias,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): CommunityNoteRetrieveContributorResponse {
        $params = Util::removeNulls(
            [
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveContributor($alias, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns a contributor's notes, newest first, each with the post it is on. Includes notes X has not rated helpful. Each note costs 1 credit. Follow next_cursor for more.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Notes per page (1-10, default 10). A low credit balance can return fewer. Follow next_cursor for more pages. Also read as limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listContributorNotes(
        string $alias,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedCommunityNotes {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listContributorNotes($alias, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Returns the notes a contributor deleted, newest first. X keeps each note's ID, times, rating & tags. A notice replaces its text & post. Each note costs 1 credit. A contributor who deleted none returns an empty list, free.
     *
     * @param string|null $cursor Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     * @param int|null $pageSize Notes per page (1-10, default 10). A low credit balance can return fewer. Follow next_cursor for more pages. Also read as limit, count, max_results, maxItems, max_items & per_page.
     * @param string|null $fields Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     * @param string|null $omit Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function listContributorDeletedNotes(
        string $alias,
        ?string $cursor = null,
        ?int $pageSize = null,
        ?string $fields = null,
        ?string $omit = null,
        RequestOptions|array|null $requestOptions = null,
    ): PaginatedCommunityNotes {
        $params = Util::removeNulls(
            [
                'cursor' => $cursor,
                'pageSize' => $pageSize,
                'fields' => $fields,
                'omit' => $omit,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listContributorDeletedNotes($alias, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
