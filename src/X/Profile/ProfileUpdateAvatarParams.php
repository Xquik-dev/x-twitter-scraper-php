<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Profile;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Update profile avatar.
 *
 * @see XTwitterScraper\Services\X\ProfileService::updateAvatar()
 *
 * @phpstan-type ProfileUpdateAvatarParamsShape = array{
 *   account: string, url: string
 * }
 */
final class ProfileUpdateAvatarParams implements BaseModel
{
    /** @use SdkModel<ProfileUpdateAvatarParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or ID) receiving avatar from URL.
     */
    #[Required]
    public string $account;

    /**
     * HTTPS URL to the avatar image to download.
     */
    #[Required]
    public string $url;

    /**
     * `new ProfileUpdateAvatarParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileUpdateAvatarParams::with(account: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileUpdateAvatarParams)->withAccount(...)->withURL(...)
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
    public static function with(string $account, string $url): self
    {
        $self = new self;

        $self['account'] = $account;
        $self['url'] = $url;

        return $self;
    }

    /**
     * X account (@username or ID) receiving avatar from URL.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * HTTPS URL to the avatar image to download.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
