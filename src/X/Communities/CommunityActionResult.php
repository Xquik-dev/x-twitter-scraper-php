<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityActionResultShape = array{
 *   communityID: string, communityName: string, success: bool
 * }
 */
final class CommunityActionResult implements BaseModel
{
    /** @use SdkModel<CommunityActionResultShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required('communityId')]
    public string $communityID;

    #[Required]
    public string $communityName;

    /**
     * `new CommunityActionResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityActionResult::with(communityID: ..., communityName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityActionResult)->withCommunityID(...)->withCommunityName(...)
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
        string $communityID,
        string $communityName
    ): self {
        $self = new self;

        $self['communityID'] = $communityID;
        $self['communityName'] = $communityName;

        return $self;
    }

    public function withCommunityID(string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    public function withCommunityName(string $communityName): self
    {
        $self = clone $this;
        $self['communityName'] = $communityName;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }
}
