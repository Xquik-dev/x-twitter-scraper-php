<?php

declare(strict_types=1);

namespace XTwitterScraper\Services\X;

use XTwitterScraper\Client;
use XTwitterScraper\Core\Exceptions\APIException;
use XTwitterScraper\Core\Util;
use XTwitterScraper\RequestOptions;
use XTwitterScraper\ServiceContracts\X\ProfileContract;
use XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse;
use XTwitterScraper\X\Profile\ProfileUpdateBannerResponse;
use XTwitterScraper\X\Profile\ProfileUpdateResponse;

/**
 * X write actions (tweets, likes, follows, DMs).
 *
 * @phpstan-import-type RequestOpts from \XTwitterScraper\RequestOptions
 */
final class ProfileService implements ProfileContract
{
    /**
     * @api
     */
    public ProfileRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ProfileRawService($client);
    }

    /**
     * @api
     *
     * Update X profile
     *
     * @param string $account X account (@username or account ID)
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
    ): ProfileUpdateResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'description' => $description,
                'location' => $location,
                'name' => $name,
                'url' => $url,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update profile avatar
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
    ): ProfileUpdateAvatarResponse {
        $params = Util::removeNulls(['account' => $account, 'file' => $file]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateAvatar(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update profile banner
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
    ): ProfileUpdateBannerResponse {
        $params = Util::removeNulls(['account' => $account, 'file' => $file]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateBanner(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
