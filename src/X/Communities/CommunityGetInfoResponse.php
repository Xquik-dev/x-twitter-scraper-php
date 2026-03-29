<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityGetInfoResponseShape = array{community: mixed}
 */
final class CommunityGetInfoResponse implements BaseModel
{
    /** @use SdkModel<CommunityGetInfoResponseShape> */
    use SdkModel;

    /**
     * Community info object.
     */
    #[Required]
    public mixed $community;

    /**
     * `new CommunityGetInfoResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityGetInfoResponse::with(community: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityGetInfoResponse)->withCommunity(...)
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
    public static function with(mixed $community): self
    {
        $self = new self;

        $self['community'] = $community;

        return $self;
    }

    /**
     * Community info object.
     */
    public function withCommunity(mixed $community): self
    {
        $self = clone $this;
        $self['community'] = $community;

        return $self;
    }
}
