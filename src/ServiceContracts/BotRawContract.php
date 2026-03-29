<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Bot\BotTrackUsageParams;
use XTwitterScraper\Bot\BotTrackUsageResponse;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface BotRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|BotTrackUsageParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BotTrackUsageResponse>
     *
     * @throws APIException
     */
    public function trackUsage(
        array|BotTrackUsageParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
