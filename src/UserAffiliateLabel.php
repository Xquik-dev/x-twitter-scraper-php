<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type UserAffiliateLabelShape = array{
 *   auxiliaryLabels?: list<UserAuxiliaryLabel|array<string,mixed>>|null,
 *   badgeUrl?: string|null,
 *   description?: string|null,
 *   longDescription?: array<string,mixed>|null,
 *   url?: string|null,
 *   urlType?: string|null,
 *   userLabelDisplayType?: string|null,
 *   userLabelType?: string|null,
 * }
 */
final class UserAffiliateLabel implements BaseModel
{
    /** @use SdkModel<UserAffiliateLabelShape> */
    use SdkModel;

    /**
     * More labels X shows beside the affiliation, such as an automated account's owner.
     *
     * @var list<UserAuxiliaryLabel>|null $auxiliaryLabels
     */
    #[Optional(list: UserAuxiliaryLabel::class)]
    public ?array $auxiliaryLabels;

    #[Optional]
    public ?string $badgeUrl;

    #[Optional]
    public ?string $description;

    /**
     * Public text, ranges, references, and mention data.
     *
     * @var array<string,mixed>|null $longDescription
     */
    #[Optional(map: 'mixed')]
    public ?array $longDescription;

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
     *
     * @param list<UserAuxiliaryLabel|array<string,mixed>>|null $auxiliaryLabels
     * @param array<string,mixed>|null $longDescription
     */
    public static function with(?array $auxiliaryLabels = null, ?string $badgeUrl = null, ?string $description = null, ?array $longDescription = null, ?string $url = null, ?string $urlType = null, ?string $userLabelDisplayType = null, ?string $userLabelType = null): self
    {
        $self = new self;

        null !== $auxiliaryLabels && $self['auxiliaryLabels'] = $auxiliaryLabels;
        null !== $badgeUrl && $self['badgeUrl'] = $badgeUrl;
        null !== $description && $self['description'] = $description;
        null !== $longDescription && $self['longDescription'] = $longDescription;
        null !== $url && $self['url'] = $url;
        null !== $urlType && $self['urlType'] = $urlType;
        null !== $userLabelDisplayType && $self['userLabelDisplayType'] = $userLabelDisplayType;
        null !== $userLabelType && $self['userLabelType'] = $userLabelType;

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

    public function withBadgeUrl(?string $badgeUrl): self
    {
        $self = clone $this;
        $self['badgeUrl'] = $badgeUrl;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

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

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withUrlType(?string $urlType): self
    {
        $self = clone $this;
        $self['urlType'] = $urlType;

        return $self;
    }

    public function withUserLabelDisplayType(?string $userLabelDisplayType): self
    {
        $self = clone $this;
        $self['userLabelDisplayType'] = $userLabelDisplayType;

        return $self;
    }

    public function withUserLabelType(?string $userLabelType): self
    {
        $self = clone $this;
        $self['userLabelType'] = $userLabelType;

        return $self;
    }
}
