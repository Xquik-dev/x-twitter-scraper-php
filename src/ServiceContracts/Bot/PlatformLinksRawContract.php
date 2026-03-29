<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Bot;

use XTwitterScraper\Bot\PlatformLinks\PlatformLinkCreateParams;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteParams;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkLookupParams;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkLookupResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkNewResponse;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface PlatformLinksRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|PlatformLinkCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PlatformLinkNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PlatformLinkCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PlatformLinkDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PlatformLinkDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        array|PlatformLinkDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PlatformLinkLookupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PlatformLinkLookupResponse>
     *
     * @throws APIException
     */
    public function lookup(
        array|PlatformLinkLookupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
