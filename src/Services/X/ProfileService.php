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
     * @param string $account Body param: X account (@username or ID) to update profile
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param string $description Body param: Bio description
     * @param string $location Body param
     * @param string $name Body param: Display name
     * @param string $url Body param: Website URL
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $account,
        string $idempotencyKey,
        ?string $description = null,
        ?string $location = null,
        ?string $name = null,
        ?string $url = null,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'idempotencyKey' => $idempotencyKey,
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
     * @param string $account Body param: X account (@username or ID) receiving avatar from URL
     * @param string $url Body param: HTTPS URL to the avatar image to download
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateAvatar(
        string $account,
        string $url,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateAvatarResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'url' => $url,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateAvatar(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update profile banner
     *
     * @param string $account Body param: X account (@username or ID) receiving banner from URL
     * @param string $url Body param: HTTPS URL to the banner image to download
     * @param string $idempotencyKey Header param: Generate one unique value for each intended write. Reuse it only when retrying the exact same account, action, target, and payload. A reused key returns the original action. Reusing it with different input returns 409. Replay protection remains active for at least 90 days.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateBanner(
        string $account,
        string $url,
        string $idempotencyKey,
        RequestOptions|array|null $requestOptions = null,
    ): ProfileUpdateBannerResponse {
        $params = Util::removeNulls(
            [
                'account' => $account,
                'url' => $url,
                'idempotencyKey' => $idempotencyKey,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->updateBanner(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
