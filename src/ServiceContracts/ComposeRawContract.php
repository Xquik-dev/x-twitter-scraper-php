<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Compose\ComposeCreateParams;
use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult;
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
     * @return BaseResponse<ComposePrepareResult|ComposeRefineResult|ComposeScoreResult,>
     *
     * @throws APIException
     */
    public function create(
        array|ComposeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
