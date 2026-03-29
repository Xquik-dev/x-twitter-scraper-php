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
 *   account: string, file: string
 * }
 */
final class ProfileUpdateBannerParams implements BaseModel
{
    /** @use SdkModel<ProfileUpdateBannerParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or account ID).
     */
    #[Required]
    public string $account;

    /**
     * Banner image (max 2MB).
     */
    #[Required]
    public string $file;

    /**
     * `new ProfileUpdateBannerParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileUpdateBannerParams::with(account: ..., file: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileUpdateBannerParams)->withAccount(...)->withFile(...)
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
    public static function with(string $account, string $file): self
    {
        $self = new self;

        $self['account'] = $account;
        $self['file'] = $file;

        return $self;
    }

    /**
     * X account (@username or account ID).
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * Banner image (max 2MB).
     */
    public function withFile(string $file): self
    {
        $self = clone $this;
        $self['file'] = $file;

        return $self;
    }
}
