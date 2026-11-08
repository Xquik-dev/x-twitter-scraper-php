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
 * @phpstan-type TweetArticleMetadataShape = array{
 *   coverMedia?: array<string,mixed>|null,
 *   id?: string|null,
 *   lifecycleState?: array<string,mixed>|null,
 *   metadata?: array<string,mixed>|null,
 *   title?: string|null,
 *   previewText?: string|null,
 *   coverMediaUrl?: string|null,
 * }
 */
final class TweetArticleMetadata implements BaseModel
{
    /** @use SdkModel<TweetArticleMetadataShape> */
    use SdkModel;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $coverMedia
     */
    #[Optional(map: 'mixed')]
    public ?array $coverMedia;

    #[Optional]
    public ?string $id;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $lifecycleState
     */
    #[Optional(map: 'mixed')]
    public ?array $lifecycleState;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $metadata
     */
    #[Optional(map: 'mixed')]
    public ?array $metadata;

    #[Optional]
    public ?string $title;

    #[Optional]
    public ?string $previewText;

    #[Optional]
    public ?string $coverMediaUrl;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $coverMedia
     * @param array<string,mixed>|null $lifecycleState
     * @param array<string,mixed>|null $metadata
     */
    public static function with(?array $coverMedia = null, ?string $id = null, ?array $lifecycleState = null, ?array $metadata = null, ?string $title = null, ?string $previewText = null, ?string $coverMediaUrl = null): self
    {
        $self = new self;

        null !== $coverMedia && $self['coverMedia'] = $coverMedia;
        null !== $id && $self['id'] = $id;
        null !== $lifecycleState && $self['lifecycleState'] = $lifecycleState;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $title && $self['title'] = $title;
        null !== $previewText && $self['previewText'] = $previewText;
        null !== $coverMediaUrl && $self['coverMediaUrl'] = $coverMediaUrl;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $coverMedia
     */
    public function withCoverMedia(?array $coverMedia): self
    {
        $self = clone $this;
        $self['coverMedia'] = $coverMedia;

        return $self;
    }

    public function withId(?string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $lifecycleState
     */
    public function withLifecycleState(?array $lifecycleState): self
    {
        $self = clone $this;
        $self['lifecycleState'] = $lifecycleState;

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

    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withPreviewText(?string $previewText): self
    {
        $self = clone $this;
        $self['previewText'] = $previewText;

        return $self;
    }

    public function withCoverMediaUrl(?string $coverMediaUrl): self
    {
        $self = clone $this;
        $self['coverMediaUrl'] = $coverMediaUrl;

        return $self;
    }
}
