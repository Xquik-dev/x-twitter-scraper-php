<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X\Communities;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Communities\CommunityActionResult;
use XTwitterScraper\X\Communities\Join\JoinCreateParams;
use XTwitterScraper\X\Communities\Join\JoinDeleteAllParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface JoinRawContract
{
    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array<string,mixed>|JoinCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityActionResult>
     *
     * @throws APIException
     */
    public function create(
        string $id,
        array|JoinCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param array<string,mixed>|JoinDeleteAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<CommunityActionResult>
     *
     * @throws APIException
     */
    public function deleteAll(
        string $id,
        array|JoinDeleteAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
