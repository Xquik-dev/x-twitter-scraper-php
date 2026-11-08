<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedCommunityNotes;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\CommunityNotesRawContract;
use XTwitterScraper\X\CommunityNotes\CommunityNoteListContributorDeletedNotesParams;
use XTwitterScraper\X\CommunityNotes\CommunityNoteListContributorNotesParams;
use XTwitterScraper\X\CommunityNotes\CommunityNoteRetrieveContributorParams;
use XTwitterScraper\X\CommunityNotes\CommunityNoteRetrieveContributorResponse;

/**
 * CommunityNote operations of the Xquik API.
 *
 * @phpstan-import-type RequestOpts from RequestOptions
 */
final class CommunityNotesRawService implements CommunityNotesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Returns 1 Community Notes contributor by the alias X gives them. Includes note counts by rating, rating counts & the deleted notes count. Each lookup costs 1 credit.
     *
     * @param array<string,mixed>|CommunityNoteRetrieveContributorParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityNoteRetrieveContributorResponse>
     *
     * @throws APIException
     */
    public function retrieveContributor(
        string $alias,
        array|CommunityNoteRetrieveContributorParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CommunityNoteRetrieveContributorParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/community-notes/contributors/%1$s', $alias],
            query: $parsed,
            options: $options,
            convert: CommunityNoteRetrieveContributorResponse::class,
        );
    }

    /**
     * @api
     *
     * Returns a contributor's notes, newest first, each with the post it is on. Includes notes X has not rated helpful. Each note costs 1 credit. Follow next_cursor for more.
     *
     * @param array<string,mixed>|CommunityNoteListContributorNotesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedCommunityNotes>
     *
     * @throws APIException
     */
    public function listContributorNotes(
        string $alias,
        array|CommunityNoteListContributorNotesParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CommunityNoteListContributorNotesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/community-notes/contributors/%1$s/notes', $alias],
            query: $parsed,
            options: $options,
            convert: PaginatedCommunityNotes::class,
        );
    }

    /**
     * @api
     *
     * Returns the notes a contributor deleted, newest first. X keeps each note's ID, times, rating & tags. A notice replaces its text & post. Each note costs 1 credit. A contributor who deleted none returns an empty list, free.
     *
     * @param array<string,mixed>|CommunityNoteListContributorDeletedNotesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PaginatedCommunityNotes>
     *
     * @throws APIException
     */
    public function listContributorDeletedNotes(
        string $alias,
        array|CommunityNoteListContributorDeletedNotesParams $params = [],
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CommunityNoteListContributorDeletedNotesParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['x/community-notes/contributors/%1$s/deleted-notes', $alias],
            query: $parsed,
            options: $options,
            convert: PaginatedCommunityNotes::class,
        );
    }
}
