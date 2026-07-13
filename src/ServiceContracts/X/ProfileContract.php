<?php

declare(strict_types=1);

namespace XTwitterScraper\ServiceContracts\X;

use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse;
use XTwitterScraper\X\Profile\ProfileUpdateBannerResponse;
use XTwitterScraper\X\Profile\ProfileUpdateResponse;

/**
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
interface ProfileContract
{
    /**
     * @api
     *
     * @param string $account X account (@username or ID) to update profile
     * @param string $description Bio description
     * @param string $name Display name
     * @param string $url Website URL
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $account,
        ?string $description = null,
        ?string $location = null,
        ?string $name = null,
        ?string $url = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateResponse;

    /**
     * @api
     *
     * @param string $account X account (@username or ID) receiving avatar from URL
     * @param string $url HTTPS URL to the avatar image to download
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateAvatar(
        string $account,
        string $url,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateAvatarResponse;

    /**
     * @api
     *
     * @param string $account X account (@username or ID) receiving banner from URL
     * @param string $url HTTPS URL to the banner image to download
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateBanner(
        string $account,
        string $url,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateBannerResponse;
}
