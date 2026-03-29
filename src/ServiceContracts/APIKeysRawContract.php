<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\APIKeys\APIKeyCreateParams;
use XTwitterScraper\APIKeys\APIKeyListResponse;
use XTwitterScraper\APIKeys\APIKeyNewResponse;
use XTwitterScraper\APIKeys\APIKeyRevokeResponse;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface APIKeysRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|APIKeyCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKeyNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|APIKeyCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<APIKeyListResponse>
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
     * @return BaseResponse<APIKeyRevokeResponse>
     *
     * @throws APIException
     */
    public function revoke(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
