<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Support;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Support\TicketsContract;
use XTwitterScraper\Support\Tickets\TicketGetResponse;
use XTwitterScraper\Support\Tickets\TicketListResponse;
use XTwitterScraper\Support\Tickets\TicketNewResponse;
use XTwitterScraper\Support\Tickets\TicketReplyResponse;
use XTwitterScraper\Support\Tickets\TicketUpdateParams\Status;
use XTwitterScraper\Support\Tickets\TicketUpdateResponse;

/**
 * Support ticket management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TicketsService implements TicketsContract
{
    /**
     * @api
     */
    public TicketsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TicketsRawService($client);
    }

    /**
     * @api
     *
     * Create a support ticket
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $body,
        string $subject,
        RequestOptions|array|null $requestOptions = null,
    ): TicketNewResponse {
        $params = Util::removeNulls(['body' => $body, 'subject' => $subject]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get ticket with all messages
     *
     * @param string $id Support ticket ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): TicketGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($id, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update ticket status
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
    ): TicketUpdateResponse {
        $params = Util::removeNulls(['status' => $status]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List user's support tickets
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): TicketListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Reply to a support ticket
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
    ): TicketReplyResponse {
        $params = Util::removeNulls(['body' => $body]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->reply($id, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
