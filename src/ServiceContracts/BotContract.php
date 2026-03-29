<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts;

use XTwitterScraper\Bot\BotTrackUsageResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface BotContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function trackUsage(
        int $inputTokens,
        int $outputTokens,
        string $platformUserID,
        RequestOptions|array|null $requestOptions = null,
    ): BotTrackUsageResponse;
}
