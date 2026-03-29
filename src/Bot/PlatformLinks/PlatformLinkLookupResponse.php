<?php

declare(strict_types=1);

namespace XTwitterScraper\Bot\PlatformLinks;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PlatformLinkLookupResponseShape = array{userID: string}
 */
final class PlatformLinkLookupResponse implements BaseModel
{
    /** @use SdkModel<PlatformLinkLookupResponseShape> */
    use SdkModel;

    #[Required('userId')]
    public string $userID;

    /**
     * `new PlatformLinkLookupResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PlatformLinkLookupResponse::with(userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PlatformLinkLookupResponse)->withUserID(...)
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
    public static function with(string $userID): self
    {
        $self = new self;

        $self['userID'] = $userID;

        return $self;
    }

    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
