<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\Subscribe\SubscribeCreateParams;
use XTwitterScraper\Subscribe\SubscribeNewResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface SubscribeRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SubscribeCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SubscribeNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|SubscribeCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
