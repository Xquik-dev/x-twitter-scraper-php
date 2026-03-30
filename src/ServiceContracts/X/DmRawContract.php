<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Dm\DmGetHistoryResponse;
use XTwitterScraper\X\Dm\DmRetrieveHistoryParams;
use XTwitterScraper\X\Dm\DmSendParams;
use XTwitterScraper\X\Dm\DmSendResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface DmRawContract
{
    /**
     * @api
     *
     * @param string $userID Target user ID
     * @param array<string,mixed>|DmRetrieveHistoryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DmGetHistoryResponse>
     *
     * @throws APIException
     */
    public function retrieveHistory(
        string $userID,
        array|DmRetrieveHistoryParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $userID Recipient user ID
     * @param array<string,mixed>|DmSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DmSendResponse>
     *
     * @throws APIException
     */
    public function send(
        string $userID,
        array|DmSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
