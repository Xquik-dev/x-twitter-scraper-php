<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Media\MediaDownloadParams;
use XTwitterScraper\X\Media\MediaDownloadResponse;
use XTwitterScraper\X\Media\MediaUploadParams;
use XTwitterScraper\X\Media\MediaUploadResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface MediaRawContract
{
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

    /**
     * @api
     *
     * @param array<string,mixed>|MediaUploadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MediaUploadResponse>
     *
     * @throws APIException
     */
    public function upload(
        array|MediaUploadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
