<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Support;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface AttachmentsContract
{
    /**
     * @api
     *
     * @param string $id Support attachment public ID
     * @param string $range Optional single byte range
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function download(
        string $id,
        ?string $range = null,
        RequestOptions|array|null $requestOptions = null,
    ): string;
}
