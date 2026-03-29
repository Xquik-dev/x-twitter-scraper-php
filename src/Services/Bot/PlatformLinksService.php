<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Bot;

use XTwitterScraper\Bot\PlatformLinks\PlatformLinkCreateParams\Platform;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkLookupResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkNewResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Bot\PlatformLinksContract;

/**
 * Telegram bot service endpoints.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class PlatformLinksService implements PlatformLinksContract
{
    /**
     * @api
     */
    public PlatformLinksRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PlatformLinksRawService($client);
    }

    /**
     * @api
     *
     * Link a platform user to an Xquik account
     *
     * @param Platform|value-of<Platform> $platform
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        Platform|string $platform,
        string $platformUserID,
        RequestOptions|array|null $requestOptions = null,
    ): PlatformLinkNewResponse {
        $params = Util::removeNulls(
            ['platform' => $platform, 'platformUserID' => $platformUserID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Unlink a platform user from an Xquik account
     *
     * @param \XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteParams\Platform|value-of<\XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteParams\Platform> $platform
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        \XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteParams\Platform|string $platform,
        string $platformUserID,
        RequestOptions|array|null $requestOptions = null,
    ): PlatformLinkDeleteResponse {
        $params = Util::removeNulls(
            ['platform' => $platform, 'platformUserID' => $platformUserID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Look up an Xquik user by platform identity
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function lookup(
        string $platform,
        string $platformUserID,
        RequestOptions|array|null $requestOptions = null,
    ): PlatformLinkLookupResponse {
        $params = Util::removeNulls(
            ['platform' => $platform, 'platformUserID' => $platformUserID]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->lookup(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
