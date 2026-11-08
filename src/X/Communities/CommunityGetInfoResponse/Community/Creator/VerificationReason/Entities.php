<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityGetInfoResponse\Community\Creator\VerificationReason;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type EntitiesShape = array{
 *   fromIndex?: int|null,
 *   toIndex?: int|null,
 *   url?: string|null,
 *   urlType?: string|null,
 * }
 */
final class Entities implements BaseModel
{
    /** @use SdkModel<EntitiesShape> */
    use SdkModel;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $fromIndex;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $toIndex;

    #[Optional]
    public ?string $url;

    #[Optional]
    public ?string $urlType;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $fromIndex = null, ?int $toIndex = null, ?string $url = null, ?string $urlType = null): self
    {
        $self = new self;

        null !== $fromIndex && $self['fromIndex'] = $fromIndex;
        null !== $toIndex && $self['toIndex'] = $toIndex;
        null !== $url && $self['url'] = $url;
        null !== $urlType && $self['urlType'] = $urlType;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withFromIndex(?int $fromIndex): self
    {
        $self = clone $this;
        $self['fromIndex'] = $fromIndex;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withToIndex(?int $toIndex): self
    {
        $self = clone $this;
        $self['toIndex'] = $toIndex;

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
}
