<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Media\MediaCreateParams;
use XTwitterScraper\X\Media\MediaDownloadParams;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface MediaRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|MediaCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MediaNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|MediaCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MediaDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MediaDownloadResponse>
     *
     * @throws APIException
     */
    public function download(
        array|MediaDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
