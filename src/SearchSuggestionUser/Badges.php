<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchSuggestionUser;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type BadgesShape = array{
 *   badgeType?: string|null,
 *   badgeUrl?: string|null,
 *   description?: string|null,
 * }
 */
final class Badges implements BaseModel
{
    /** @use SdkModel<BadgesShape> */
    use SdkModel;

    /**
     * Kind of badge.
     */
    #[Optional]
    public ?string $badgeType;

    /**
     * Badge image URL.
     */
    #[Optional]
    public ?string $badgeUrl;

    /**
     * Name of the affiliated account.
     */
    #[Optional]
    public ?string $description;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $badgeType = null, ?string $badgeUrl = null, ?string $description = null): self
    {
        $self = new self;

        null !== $badgeType && $self['badgeType'] = $badgeType;
        null !== $badgeUrl && $self['badgeUrl'] = $badgeUrl;
        null !== $description && $self['description'] = $description;

        return $self;
    }

    /**
     * Kind of badge.
     */
    public function withBadgeType(?string $badgeType): self
    {
        $self = clone $this;
        $self['badgeType'] = $badgeType;

        return $self;
    }

    /**
     * Badge image URL.
     */
    public function withBadgeUrl(?string $badgeUrl): self
    {
        $self = clone $this;
        $self['badgeUrl'] = $badgeUrl;

        return $self;
    }

    /**
     * Name of the affiliated account.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
