<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\ProfileRawContract;
use XTwitterScraper\X\Profile\ProfilePatchAllParams;
use XTwitterScraper\X\Profile\ProfilePatchAllResponse;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarParams;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse;
use XTwitterScraper\X\Profile\ProfileUpdateBannerParams;
use XTwitterScraper\X\Profile\ProfileUpdateBannerResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ProfileRawService implements ProfileRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Update X profile
     *
     * @param array{
     *   account: string,
     *   description?: string,
     *   location?: string,
     *   name?: string,
     *   url?: string,
     * }|ProfilePatchAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfilePatchAllResponse>
     *
     * @throws APIException
     */
    public function patchAll(
        array|ProfilePatchAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfilePatchAllParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: 'x/profile',
            body: (object) $parsed,
            options: $options,
            convert: ProfilePatchAllResponse::class,
        );
    }

    /**
     * @api
     *
     * Update profile avatar
     *
     * @param array{account: string, file: string}|ProfileUpdateAvatarParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileUpdateAvatarResponse>
     *
     * @throws APIException
     */
    public function updateAvatar(
        array|ProfileUpdateAvatarParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileUpdateAvatarParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: 'x/profile/avatar',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: ProfileUpdateAvatarResponse::class,
        );
    }

    /**
     * @api
     *
     * Update profile banner
     *
     * @param array{account: string, file: string}|ProfileUpdateBannerParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileUpdateBannerResponse>
     *
     * @throws APIException
     */
    public function updateBanner(
        array|ProfileUpdateBannerParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProfileUpdateBannerParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: 'x/profile/banner',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: (object) $parsed,
            options: $options,
            convert: ProfileUpdateBannerResponse::class,
        );
    }
}
