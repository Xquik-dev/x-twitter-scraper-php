<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet2;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type LiveEventContextShape = array{
 *   title?: string|null,
 *   url?: string|null,
 *   imageUrl?: string|null,
 * }
 */
final class LiveEventContext implements BaseModel
{
    /** @use SdkModel<LiveEventContextShape> */
    use SdkModel;

    /**
     * Event name.
     */
    #[Optional]
    public ?string $title;

    /**
     * The event's page on X.
     */
    #[Optional]
    public ?string $url;

    /**
     * The event's image.
     */
    #[Optional]
    public ?string $imageUrl;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $title = null, ?string $url = null, ?string $imageUrl = null): self
    {
        $self = new self;

        null !== $title && $self['title'] = $title;
        null !== $url && $self['url'] = $url;
        null !== $imageUrl && $self['imageUrl'] = $imageUrl;

        return $self;
    }

    /**
     * Event name.
     */
    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * The event's page on X.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * The event's image.
     */
    public function withImageUrl(?string $imageUrl): self
    {
        $self = clone $this;
        $self['imageUrl'] = $imageUrl;

        return $self;
    }
}
