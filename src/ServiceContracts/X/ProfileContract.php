<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Profile\ProfilePatchAllResponse;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse;
use XTwitterScraper\X\Profile\ProfileUpdateBannerResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ProfileContract
{
    /**
     * @api
     *
     * @param string $account X account (@username or account ID)
     * @param string $description Bio description
     * @param string $name Display name
     * @param string $url Website URL
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function patchAll(
        string $account,
        ?string $description = null,
        ?string $location = null,
        ?string $name = null,
        ?string $url = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProfilePatchAllResponse;

    /**
     * @api
     *
     * @param string $account X account (@username or account ID)
     * @param string $file Avatar image (max 716KB)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateAvatar(
        string $account,
        string $file,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateAvatarResponse;

    /**
     * @api
     *
     * @param string $account X account (@username or account ID)
     * @param string $file Banner image (max 2MB)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateBanner(
        string $account,
        string $file,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateBannerResponse;
}
