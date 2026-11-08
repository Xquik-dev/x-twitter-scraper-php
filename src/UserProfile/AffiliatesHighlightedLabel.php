<?php

declare(strict_types=1);

namespace XTwitterScraper\UserProfile;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\UserAuxiliaryLabel;

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
 *   auxiliaryLabels?: list<UserAuxiliaryLabel|array<string,mixed>>|null,
 *   longDescription?: array<string,mixed>|null,
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

    /**
     * More labels X shows beside the affiliation, such as an automated account's owner.
     *
     * @var list<UserAuxiliaryLabel>|null $auxiliaryLabels
     */
    #[Optional(list: UserAuxiliaryLabel::class)]
    public ?array $auxiliaryLabels;

    /**
     * Public text, ranges, references, and mention data.
     *
     * @var array<string,mixed>|null $longDescription
     */
    #[Optional(map: 'mixed')]
    public ?array $longDescription;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<UserAuxiliaryLabel|array<string,mixed>>|null $auxiliaryLabels
     * @param array<string,mixed>|null $longDescription
     */
    public static function with(
        ?string $badgeURL = null,
        ?string $description = null,
        ?string $url = null,
        ?string $urlType = null,
        ?string $userLabelDisplayType = null,
        ?string $userLabelType = null,
        ?array $auxiliaryLabels = null,
        ?array $longDescription = null
    ): self {
        $self = new self;

        null !== $badgeURL && $self['badgeURL'] = $badgeURL;
        null !== $description && $self['description'] = $description;
        null !== $url && $self['url'] = $url;
        null !== $urlType && $self['urlType'] = $urlType;
        null !== $userLabelDisplayType && $self['userLabelDisplayType'] = $userLabelDisplayType;
        null !== $userLabelType && $self['userLabelType'] = $userLabelType;

        null !== $auxiliaryLabels && $self['auxiliaryLabels'] = $auxiliaryLabels;

        null !== $longDescription && $self['longDescription'] = $longDescription;

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

    /**
     * More labels X shows beside the affiliation, such as an automated account's owner.
     *
     * @param list<UserAuxiliaryLabel|array<string,mixed>>|null $auxiliaryLabels
     */
    public function withAuxiliaryLabels(?array $auxiliaryLabels): self
    {
        $self = clone $this;
        $self['auxiliaryLabels'] = $auxiliaryLabels;

        return $self;
    }

    /**
     * Public text, ranges, references, and mention data.
     *
     * @param array<string,mixed>|null $longDescription
     */
    public function withLongDescription(?array $longDescription): self
    {
        $self = clone $this;
        $self['longDescription'] = $longDescription;

        return $self;
    }
}
