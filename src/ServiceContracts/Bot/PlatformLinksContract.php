<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\Bot;

use XTwitterScraper\Bot\PlatformLinks\PlatformLinkCreateParams\Platform;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkLookupResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkNewResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface PlatformLinksContract
{
    /**
     * @api
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
    ): PlatformLinkNewResponse;

    /**
     * @api
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
    ): PlatformLinkDeleteResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function lookup(
        string $platform,
        string $platformUserID,
        RequestOptions|array|null $requestOptions = null,
    ): PlatformLinkLookupResponse;
}
