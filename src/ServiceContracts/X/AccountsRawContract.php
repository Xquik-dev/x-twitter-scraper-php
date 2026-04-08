<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Accounts\AccountBulkRetryResponse;
use XTwitterScraper\X\Accounts\AccountCreateParams;
use XTwitterScraper\X\Accounts\AccountDeleteResponse;
use XTwitterScraper\X\Accounts\AccountListResponse;
use XTwitterScraper\X\Accounts\AccountNewResponse;
use XTwitterScraper\X\Accounts\AccountReauthParams;
use XTwitterScraper\X\Accounts\AccountReauthResponse;
use XTwitterScraper\X\Accounts\XAccountDetail;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AccountCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AccountCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<XAccountDetail>
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountBulkRetryResponse>
     *
     * @throws APIException
     */
    public function bulkRetry(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array<string,mixed>|AccountReauthParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountReauthResponse>
     *
     * @throws APIException
     */
    public function reauth(
        string $id,
        array|AccountReauthParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
