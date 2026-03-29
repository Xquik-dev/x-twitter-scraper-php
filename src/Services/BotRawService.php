<?php

declare(strict_types=1);

namespace XTwitterScraper\Services;

use XTwitterScraper\Bot\BotTrackUsageParams;
use XTwitterScraper\Bot\BotTrackUsageResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\BotRawContract;

/**
 * Telegram bot service endpoints.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class BotRawService implements BotRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Track bot token usage
     *
     * @param array{
     *   inputTokens: int, outputTokens: int, platformUserID: string
     * }|BotTrackUsageParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BotTrackUsageResponse>
     *
     * @throws APIException
     */
    public function trackUsage(
        array|BotTrackUsageParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = BotTrackUsageParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'bot/usage',
            body: (object) $parsed,
            options: $options,
            convert: BotTrackUsageResponse::class,
        );
    }
}
