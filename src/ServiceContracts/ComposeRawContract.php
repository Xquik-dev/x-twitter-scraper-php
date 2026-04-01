<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Compose\ComposeCreateParams;
use XTwitterScraper\Compose\ComposeNewResponse;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ComposeRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ComposeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ComposeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|ComposeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
