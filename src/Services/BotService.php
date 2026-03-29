<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Bot\BotTrackUsageResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\BotContract;
use XTwitterScraper\Services\Bot\PlatformLinksService;

/**
 * Telegram bot service endpoints.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class BotService implements BotContract
{
    /**
     * @api
     */
    public BotRawService $raw;

    /**
     * @api
     */
    public PlatformLinksService $platformLinks;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BotRawService($client);
        $this->platformLinks = new PlatformLinksService($client);
    }

    /**
     * @api
     *
     * Track bot token usage
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
    ): BotTrackUsageResponse {
        $params = Util::removeNulls(
            [
                'inputTokens' => $inputTokens,
                'outputTokens' => $outputTokens,
                'platformUserID' => $platformUserID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->trackUsage(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
