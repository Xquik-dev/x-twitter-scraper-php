<?php

declare(strict_types=1);

namespace XTwitterScraper\Bot\PlatformLinks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Look up an Xquik user by platform identity.
 *
 * @see XTwitterScraper\Services\Bot\PlatformLinksService::lookup()
 *
 * @phpstan-type PlatformLinkLookupParamsShape = array{
 *   platform: string, platformUserID: string
 * }
 */
final class PlatformLinkLookupParams implements BaseModel
{
    /** @use SdkModel<PlatformLinkLookupParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $platform;

    #[Required]
    public string $platformUserID;

    /**
     * `new PlatformLinkLookupParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PlatformLinkLookupParams::with(platform: ..., platformUserID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PlatformLinkLookupParams)->withPlatform(...)->withPlatformUserID(...)
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
    public static function with(string $platform, string $platformUserID): self
    {
        $self = new self;

        $self['platform'] = $platform;
        $self['platformUserID'] = $platformUserID;

        return $self;
    }

    public function withPlatform(string $platform): self
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
