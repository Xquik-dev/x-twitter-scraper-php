<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Account\AccountGetResponse;
use XTwitterScraper\Account\AccountSetXUsernameParams;
use XTwitterScraper\Account\AccountSetXUsernameResponse;
use XTwitterScraper\Account\AccountUpdateLocaleParams;
use XTwitterScraper\Account\AccountUpdateLocaleResponse;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AccountRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AccountSetXUsernameParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountSetXUsernameResponse>
     *
     * @throws APIException
     */
    public function setXUsername(
        array|AccountSetXUsernameParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AccountUpdateLocaleParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AccountUpdateLocaleResponse>
     *
     * @throws APIException
     */
    public function updateLocale(
        array|AccountUpdateLocaleParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
