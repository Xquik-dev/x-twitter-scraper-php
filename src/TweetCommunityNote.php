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
 * @phpstan-type TweetCommunityNoteShape = array{
 *   id?: string|null,
 *   title?: string|null,
 *   shortTitle?: string|null,
 *   subtitle?: string|null,
 *   footer?: string|null,
 *   footerIconType?: string|null,
 *   destinationUrl?: string|null,
 *   iconType?: string|null,
 *   visualStyle?: string|null,
 *   metadata?: array<string,mixed>|null,
 * }
 */
final class TweetCommunityNote implements BaseModel
{
    /** @use SdkModel<TweetCommunityNoteShape> */
    use SdkModel;

    #[Optional]
    public ?string $id;

    #[Optional]
    public ?string $title;

    #[Optional]
    public ?string $shortTitle;

    #[Optional]
    public ?string $subtitle;

    #[Optional]
    public ?string $footer;

    #[Optional]
    public ?string $footerIconType;

    #[Optional]
    public ?string $destinationUrl;

    #[Optional]
    public ?string $iconType;

    #[Optional]
    public ?string $visualStyle;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $metadata
     */
    #[Optional(map: 'mixed')]
    public ?array $metadata;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $metadata
     */
    public static function with(?string $id = null, ?string $title = null, ?string $shortTitle = null, ?string $subtitle = null, ?string $footer = null, ?string $footerIconType = null, ?string $destinationUrl = null, ?string $iconType = null, ?string $visualStyle = null, ?array $metadata = null): self
    {
        $self = new self;

        null !== $id && $self['id'] = $id;
        null !== $title && $self['title'] = $title;
        null !== $shortTitle && $self['shortTitle'] = $shortTitle;
        null !== $subtitle && $self['subtitle'] = $subtitle;
        null !== $footer && $self['footer'] = $footer;
        null !== $footerIconType && $self['footerIconType'] = $footerIconType;
        null !== $destinationUrl && $self['destinationUrl'] = $destinationUrl;
        null !== $iconType && $self['iconType'] = $iconType;
        null !== $visualStyle && $self['visualStyle'] = $visualStyle;
        null !== $metadata && $self['metadata'] = $metadata;

        return $self;
    }

    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withShortTitle(?string $shortTitle): self
    {
        $self = clone $this;
        $self['shortTitle'] = $shortTitle;

        return $self;
    }

    public function withSubtitle(?string $subtitle): self
    {
        $self = clone $this;
        $self['subtitle'] = $subtitle;

        return $self;
    }

    public function withFooter(?string $footer): self
    {
        $self = clone $this;
        $self['footer'] = $footer;

        return $self;
    }

    public function withFooterIconType(?string $footerIconType): self
    {
        $self = clone $this;
        $self['footerIconType'] = $footerIconType;

        return $self;
    }

    public function withDestinationUrl(?string $destinationUrl): self
    {
        $self = clone $this;
        $self['destinationUrl'] = $destinationUrl;

        return $self;
    }

    public function withIconType(?string $iconType): self
    {
        $self = clone $this;
        $self['iconType'] = $iconType;

        return $self;
    }

    public function withVisualStyle(?string $visualStyle): self
    {
        $self = clone $this;
        $self['visualStyle'] = $visualStyle;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }
}
