<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Support;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Support\Attachments\AttachmentDownloadParams;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AttachmentsRawContract
{
    /**
     * @api
     *
     * @param string $id Support attachment public ID
     * @param array<string,mixed>|AttachmentDownloadParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<string>
     *
     * @throws APIException
     */
    public function download(
        string $id,
        array|AttachmentDownloadParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
