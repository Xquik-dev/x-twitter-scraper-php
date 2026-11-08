<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\PaginatedCommunityNotes;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\CommunityNotes\CommunityNoteListContributorDeletedNotesParams;
use XTwitterScraper\X\CommunityNotes\CommunityNoteListContributorNotesParams;
use XTwitterScraper\X\CommunityNotes\CommunityNoteRetrieveContributorParams;
use XTwitterScraper\X\CommunityNotes\CommunityNoteRetrieveContributorResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface CommunityNotesRawContract
{
    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
