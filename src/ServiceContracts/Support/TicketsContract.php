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
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $body,
        string $subject,
        RequestOptions|array|null $requestOptions = null,
    ): TicketNewResponse;

    /**
     * @api
     *
     * @param string $id Support ticket ID
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
     * @param string $id Support ticket ID to update
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
     * @param string $id Support ticket ID for the reply
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function reply(
        string $id,
        string $body,
        RequestOptions|array|null $requestOptions = null
    ): TicketReplyResponse;
}
