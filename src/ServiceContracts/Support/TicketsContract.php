<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Support;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Support\Tickets\TicketGetResponse;
use XTwitterScraper\Support\Tickets\TicketListResponse;
use XTwitterScraper\Support\Tickets\TicketNewResponse;
use XTwitterScraper\Support\Tickets\TicketReplyResponse;
use XTwitterScraper\Support\Tickets\TicketUpdateParams\Status;
use XTwitterScraper\Support\Tickets\TicketUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from RequestOptions
 */
interface TicketsContract
{
    /**
     * @api
     *
     * @param string $body Body param
     * @param string $subject Body param
     * @param string $idempotencyKey Header param: Generate one random value per ticket or reply. Reuse it only when retrying identical text and attachments. Never log this value.
     * @param list<string>|null $attachments 1 to 4 support image or video uploads
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $body,
        string $subject,
        ?string $idempotencyKey = null,
        ?array $attachments = null,
        RequestOptions|array|null $requestOptions = null,
    ): TicketNewResponse;

    /**
     * @api
     *
     * @param string $id Support ticket public ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): TicketGetResponse;

    /**
     * @api
     *
     * @param string $id Support ticket public ID to update
     * @param Status|value-of<Status> $status
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $id,
        Status|string $status,
        RequestOptions|array|null $requestOptions = null,
    ): TicketUpdateResponse;

    /**
     * @api
     *
     * @param int|null $limit Maximum items per page, from 1 to 10,000. Default 200. Pass nextCursor as cursor for the next page.
     * @param string|null $cursor Previous nextCursor. The after alias also works. Offset pagination is not supported.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        ?int $limit = null,
        ?string $cursor = null,
        RequestOptions|array|null $requestOptions = null
    ): TicketListResponse;

    /**
     * @api
     *
     * @param string $id Path param: Support ticket public ID for the reply
     * @param string $body Body param
     * @param string $idempotencyKey Header param: Generate one random value per ticket or reply. Reuse it only when retrying identical text and attachments. Never log this value.
     * @param list<string>|null $attachments 1 to 4 support image or video uploads
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function reply(
        string $id,
        string $body,
        ?string $idempotencyKey = null,
        ?array $attachments = null,
        RequestOptions|array|null $requestOptions = null,
    ): TicketReplyResponse;
}
