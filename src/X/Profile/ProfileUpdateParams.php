<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Profile;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Update X profile.
 *
 * @see XTwitterScraper\Services\X\ProfileService::update()
 *
 * @phpstan-type ProfileUpdateParamsShape = array{
 *   account: string,
 *   description?: string|null,
 *   location?: string|null,
 *   name?: string|null,
 *   url?: string|null,
 * }
 */
final class ProfileUpdateParams implements BaseModel
{
    /** @use SdkModel<ProfileUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X account (@username or ID) to update profile.
     */
    #[Required]
    public string $account;

    /**
     * Bio description.
     */
    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $location;

    /**
     * Display name.
     */
    #[Optional]
    public ?string $name;

    /**
     * Website URL.
     */
    #[Optional]
    public ?string $url;

    /**
     * `new ProfileUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileUpdateParams::with(account: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileUpdateParams)->withAccount(...)
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
        ?string $description = null,
        ?string $location = null,
        ?string $name = null,
        ?string $url = null,
    ): self {
        $self = new self;

        $self['account'] = $account;

        null !== $description && $self['description'] = $description;
        null !== $location && $self['location'] = $location;
        null !== $name && $self['name'] = $name;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * X account (@username or ID) to update profile.
     */
    public function withAccount(string $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * Bio description.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withLocation(string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * Display name.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Website URL.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
