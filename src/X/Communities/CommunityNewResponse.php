<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityNewResponseShape = array{
 *   communityID: string, success: bool, communityName?: string|null
 * }
 */
final class CommunityNewResponse implements BaseModel
{
    /** @use SdkModel<CommunityNewResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required('communityId')]
    public string $communityID;

    #[Optional]
    public ?string $communityName;

    /**
     * `new CommunityNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityNewResponse::with(communityID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityNewResponse)->withCommunityID(...)
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
        ?string $communityName = null
    ): self {
        $self = new self;

        $self['communityID'] = $communityID;

        null !== $communityName && $self['communityName'] = $communityName;

        return $self;
    }

    public function withCommunityID(string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    public function withCommunityName(string $communityName): self
    {
        $self = clone $this;
        $self['communityName'] = $communityName;

        return $self;
    }
}
