<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Support;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Support\TicketsRawContract;
use XTwitterScraper\Support\Tickets\TicketCreateParams;
use XTwitterScraper\Support\Tickets\TicketGetResponse;
use XTwitterScraper\Support\Tickets\TicketListResponse;
use XTwitterScraper\Support\Tickets\TicketNewResponse;
use XTwitterScraper\Support\Tickets\TicketReplyParams;
use XTwitterScraper\Support\Tickets\TicketReplyResponse;
use XTwitterScraper\Support\Tickets\TicketUpdateParams;
use XTwitterScraper\Support\Tickets\TicketUpdateParams\Status;
use XTwitterScraper\Support\Tickets\TicketUpdateResponse;

/**
 * Support ticket management.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class TicketsRawService implements TicketsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a support ticket
     *
     * @param array{body: string, subject: string}|TicketCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TicketNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|TicketCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TicketCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'support/tickets',
            body: (object) $parsed,
            options: $options,
            convert: TicketNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get ticket with all messages
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TicketGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['support/tickets/%1$s', $id],
            options: $requestOptions,
            convert: TicketGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update ticket status
     *
     * @param array{status: Status|value-of<Status>}|TicketUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TicketUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $id,
        array|TicketUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TicketUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['support/tickets/%1$s', $id],
            body: (object) $parsed,
            options: $options,
            convert: TicketUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List user's support tickets
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TicketListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'support/tickets',
            options: $requestOptions,
            convert: TicketListResponse::class,
        );
    }

    /**
     * @api
     *
     * Reply to a support ticket
     *
     * @param array{body: string}|TicketReplyParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TicketReplyResponse>
     *
     * @throws APIException
     */
    public function reply(
        string $id,
        array|TicketReplyParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TicketReplyParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['support/tickets/%1$s/messages', $id],
            body: (object) $parsed,
            options: $options,
            convert: TicketReplyResponse::class,
        );
    }
}
