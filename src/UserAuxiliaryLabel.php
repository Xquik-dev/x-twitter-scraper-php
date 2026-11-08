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
 * @phpstan-type UserAuxiliaryLabelShape = array{
 *   badgeUrl?: string|null,
 *   description?: string|null,
 *   url?: string|null,
 *   userLabelDisplayType?: string|null,
 *   userLabelType?: string|null,
 * }
 */
final class UserAuxiliaryLabel implements BaseModel
{
    /** @use SdkModel<UserAuxiliaryLabelShape> */
    use SdkModel;

    #[Optional]
    public ?string $badgeUrl;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $url;

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
    public static function with(?string $badgeUrl = null, ?string $description = null, ?string $url = null, ?string $userLabelDisplayType = null, ?string $userLabelType = null): self
    {
        $self = new self;

        null !== $badgeUrl && $self['badgeUrl'] = $badgeUrl;
        null !== $description && $self['description'] = $description;
        null !== $url && $self['url'] = $url;
        null !== $userLabelDisplayType && $self['userLabelDisplayType'] = $userLabelDisplayType;
        null !== $userLabelType && $self['userLabelType'] = $userLabelType;

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

    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

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
