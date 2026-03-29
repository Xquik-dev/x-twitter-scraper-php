<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Support;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Support\Tickets\TicketCreateParams;
use XTwitterScraper\Support\Tickets\TicketGetResponse;
use XTwitterScraper\Support\Tickets\TicketListResponse;
use XTwitterScraper\Support\Tickets\TicketNewResponse;
use XTwitterScraper\Support\Tickets\TicketReplyParams;
use XTwitterScraper\Support\Tickets\TicketReplyResponse;
use XTwitterScraper\Support\Tickets\TicketUpdateParams;
use XTwitterScraper\Support\Tickets\TicketUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface TicketsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TicketCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TicketNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|TicketCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TicketUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TicketListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TicketReplyParams $params
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
    ): BaseResponse;
}
