<?php

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
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface TicketsContract
{
    /**
     * @api
     *
     * @param string $body Body param
     * @param string $subject Body param
     * @param string $idempotencyKey Header param: Generate one random value per ticket or reply. Reuse it only when retrying identical text and attachments. Never log this value.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $body,
        string $subject,
        ?string $idempotencyKey = null,
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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): TicketListResponse;

    /**
     * @api
     *
     * @param string $id Path param: Support ticket public ID for the reply
     * @param string $body Body param
     * @param string $idempotencyKey Header param: Generate one random value per ticket or reply. Reuse it only when retrying identical text and attachments. Never log this value.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function reply(
        string $id,
        string $body,
        ?string $idempotencyKey = null,
        RequestOptions|array|null $requestOptions = null,
    ): TicketReplyResponse;
}
