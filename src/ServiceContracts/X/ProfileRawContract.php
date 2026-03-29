<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Contracts\BaseResponse;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Profile\ProfilePatchAllParams;
use XTwitterScraper\X\Profile\ProfilePatchAllResponse;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarParams;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse;
use XTwitterScraper\X\Profile\ProfileUpdateBannerParams;
use XTwitterScraper\X\Profile\ProfileUpdateBannerResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ProfileRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ProfilePatchAllParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfilePatchAllResponse>
     *
     * @throws APIException
     */
    public function patchAll(
        array|ProfilePatchAllParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProfileUpdateAvatarParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileUpdateAvatarResponse>
     *
     * @throws APIException
     */
    public function updateAvatar(
        array|ProfileUpdateAvatarParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ProfileUpdateBannerParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ProfileUpdateBannerResponse>
     *
     * @throws APIException
     */
    public function updateBanner(
        array|ProfileUpdateBannerParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
