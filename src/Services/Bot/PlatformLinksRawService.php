<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\Bot;

use XTwitterScraper\Bot\PlatformLinks\PlatformLinkCreateParams;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkCreateParams\Platform;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteParams;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkLookupParams;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkLookupResponse;
use XTwitterScraper\Bot\PlatformLinks\PlatformLinkNewResponse;
use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\Bot\PlatformLinksRawContract;

/**
 * Telegram bot service endpoints.
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class PlatformLinksRawService implements PlatformLinksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Link a platform user to an Xquik account
     *
     * @param array{
     *   platform: Platform|value-of<Platform>, platformUserID: string
     * }|PlatformLinkCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PlatformLinkNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|PlatformLinkCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PlatformLinkCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'bot/platform-links',
            body: (object) $parsed,
            options: $options,
            convert: PlatformLinkNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Unlink a platform user from an Xquik account
     *
     * @param array{
     *   platform: PlatformLinkDeleteParams\Platform|value-of<PlatformLinkDeleteParams\Platform>,
     *   platformUserID: string,
     * }|PlatformLinkDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PlatformLinkDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        array|PlatformLinkDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PlatformLinkDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: 'bot/platform-links',
            body: (object) $parsed,
            options: $options,
            convert: PlatformLinkDeleteResponse::class,
        );
    }

    /**
     * @api
     *
     * Look up an Xquik user by platform identity
     *
     * @param array{
     *   platform: string, platformUserID: string
     * }|PlatformLinkLookupParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PlatformLinkLookupResponse>
     *
     * @throws APIException
     */
    public function lookup(
        array|PlatformLinkLookupParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PlatformLinkLookupParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'bot/platform-links/lookup',
            query: Util::array_transform_keys(
                $parsed,
                ['platformUserID' => 'platformUserId']
            ),
            options: $options,
            convert: PlatformLinkLookupResponse::class,
        );
    }
}
