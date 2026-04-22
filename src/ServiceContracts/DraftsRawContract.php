<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Drafts\DraftCreateParams;
use XTwitterScraper\Drafts\DraftDetail;
use XTwitterScraper\Drafts\DraftListParams;
use XTwitterScraper\Drafts\DraftListResponse;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface DraftsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|DraftCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DraftDetail>
     *
     * @throws APIException
     */
    public function create(
        array|DraftCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DraftDetail>
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
     * @param array<string,mixed>|DraftListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DraftListResponse>
     *
     * @throws APIException
     */
    public function list(
        array|DraftListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $id Resource ID (stringified bigint)
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $id,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
