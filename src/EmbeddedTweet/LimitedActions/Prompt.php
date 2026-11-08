<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet\LimitedActions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type PromptShape = array{
 *   ctaType?: string|null,
 *   headline?: string|null,
 *   metadata?: array<string,mixed>|null,
 *   subtext?: string|null,
 * }
 */
final class Prompt implements BaseModel
{
    /** @use SdkModel<PromptShape> */
    use SdkModel;

    #[Optional]
    public ?string $ctaType;

    #[Optional]
    public ?string $headline;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $metadata
     */
    #[Optional(map: 'mixed')]
    public ?array $metadata;

    #[Optional]
    public ?string $subtext;

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
    public static function with(?string $ctaType = null, ?string $headline = null, ?array $metadata = null, ?string $subtext = null): self
    {
        $self = new self;

        null !== $ctaType && $self['ctaType'] = $ctaType;
        null !== $headline && $self['headline'] = $headline;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $subtext && $self['subtext'] = $subtext;

        return $self;
    }

    public function withCtaType(?string $ctaType): self
    {
        $self = clone $this;
        $self['ctaType'] = $ctaType;

        return $self;
    }

    public function withHeadline(?string $headline): self
    {
        $self = clone $this;
        $self['headline'] = $headline;

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

    public function withSubtext(?string $subtext): self
    {
        $self = clone $this;
        $self['subtext'] = $subtext;

        return $self;
    }
}
