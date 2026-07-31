<?php

declare(strict_types=1);

namespace XTwitterScraper\UserProfile;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Organization affiliation label shown on an X profile.
 *
 * @phpstan-type AffiliatesHighlightedLabelShape = array{
 *   badgeURL?: string|null,
 *   description?: string|null,
 *   url?: string|null,
 *   urlType?: string|null,
 *   userLabelDisplayType?: string|null,
 *   userLabelType?: string|null,
 * }
 */
final class AffiliatesHighlightedLabel implements BaseModel
{
    /** @use SdkModel<AffiliatesHighlightedLabelShape> */
    use SdkModel;

    #[Optional('badgeUrl')]
    public ?string $badgeURL;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $url;

    #[Optional]
    public ?string $urlType;

    #[Optional]
    public ?string $userLabelDisplayType;

    #[Optional]
    public ?string $userLabelType;

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
        ?string $badgeURL = null,
        ?string $description = null,
        ?string $url = null,
        ?string $urlType = null,
        ?string $userLabelDisplayType = null,
        ?string $userLabelType = null,
    ): self {
        $self = new self;

        null !== $badgeURL && $self['badgeURL'] = $badgeURL;
        null !== $description && $self['description'] = $description;
        null !== $url && $self['url'] = $url;
        null !== $urlType && $self['urlType'] = $urlType;
        null !== $userLabelDisplayType && $self['userLabelDisplayType'] = $userLabelDisplayType;
        null !== $userLabelType && $self['userLabelType'] = $userLabelType;

        return $self;
    }

    public function withBadgeURL(string $badgeURL): self
    {
        $self = clone $this;
        $self['badgeURL'] = $badgeURL;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withURLType(string $urlType): self
    {
        $self = clone $this;
        $self['urlType'] = $urlType;

        return $self;
    }

    public function withUserLabelDisplayType(string $userLabelDisplayType): self
    {
        $self = clone $this;
        $self['userLabelDisplayType'] = $userLabelDisplayType;

        return $self;
    }

    public function withUserLabelType(string $userLabelType): self
    {
        $self = clone $this;
        $self['userLabelType'] = $userLabelType;

        return $self;
    }
}
