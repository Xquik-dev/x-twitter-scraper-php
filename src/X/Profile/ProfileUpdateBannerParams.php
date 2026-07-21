<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Profile;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Update profile banner.
 *
 * @see XTwitterScraper\Services\X\ProfileService::updateBanner()
 *
 * @phpstan-type ProfileUpdateBannerParamsShape = array{
 *   account: string, url: string, idempotencyKey: string
 * }
 */
final class ProfileUpdateBannerParams implements BaseModel
{
    /** @use SdkModel<ProfileUpdateBannerParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or ID) receiving banner from URL.
     */
    #[Required]
    public string $account;

    /**
     * HTTPS URL to the banner image to download.
     */
    #[Required]
    public string $url;

    #[Required]
    public string $idempotencyKey;

    /**
     * `new ProfileUpdateBannerParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileUpdateBannerParams::with(account: ..., url: ..., idempotencyKey: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileUpdateBannerParams)
     *   ->withAccount(...)
     *   ->withURL(...)
     *   ->withIdempotencyKey(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $account,
        string $url,
        string $idempotencyKey
    ): self {
        $self = new self;

        $self['account'] = $account;
        $self['url'] = $url;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }

    /**
     * X account (@username or ID) receiving banner from URL.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * HTTPS URL to the banner image to download.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withIdempotencyKey(string $idempotencyKey): self
    {
        $self = clone $this;
        $self['idempotencyKey'] = $idempotencyKey;

        return $self;
    }
}
