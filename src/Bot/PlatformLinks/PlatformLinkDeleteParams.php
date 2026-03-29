<?php

declare(strict_types=1);

namespace XTwitterScraper\Bot\PlatformLinks;

use XTwitterScraper\Bot\PlatformLinks\PlatformLinkDeleteParams\Platform;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Unlink a platform user from an Xquik account.
 *
 * @see XTwitterScraper\Services\Bot\PlatformLinksService::delete()
 *
 * @phpstan-type PlatformLinkDeleteParamsShape = array{
 *   platform: Platform|value-of<Platform>, platformUserID: string
 * }
 */
final class PlatformLinkDeleteParams implements BaseModel
{
    /** @use SdkModel<PlatformLinkDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var value-of<Platform> $platform */
    #[Required(enum: Platform::class)]
    public string $platform;

    #[Required('platformUserId')]
    public string $platformUserID;

    /**
     * `new PlatformLinkDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PlatformLinkDeleteParams::with(platform: ..., platformUserID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PlatformLinkDeleteParams)->withPlatform(...)->withPlatformUserID(...)
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
     *
     * @param Platform|value-of<Platform> $platform
     */
    public static function with(
        Platform|string $platform,
        string $platformUserID
    ): self {
        $self = new self;

        $self['platform'] = $platform;
        $self['platformUserID'] = $platformUserID;

        return $self;
    }

    /**
     * @param Platform|value-of<Platform> $platform
     */
    public function withPlatform(Platform|string $platform): self
    {
        $self = clone $this;
        $self['platform'] = $platform;

        return $self;
    }

    public function withPlatformUserID(string $platformUserID): self
    {
        $self = clone $this;
        $self['platformUserID'] = $platformUserID;

        return $self;
    }
}
