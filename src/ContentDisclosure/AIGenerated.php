<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ContentDisclosure;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AIGeneratedShape = array{
 *   canEdit?: bool|null,
 *   detectionSource?: string|null,
 *   hasAIGeneratedMedia?: bool|null,
 * }
 */
final class AIGenerated implements BaseModel
{
    /** @use SdkModel<AIGeneratedShape> */
    use SdkModel;

    /**
     * Whether the disclosure can be edited on X.
     */
    #[Optional]
    public ?bool $canEdit;

    /**
     * Source of the AI-generated media disclosure.
     */
    #[Optional]
    public ?string $detectionSource;

    /**
     * True when X labels the tweet as containing AI-generated media.
     */
    #[Optional('hasAiGeneratedMedia')]
    public ?bool $hasAIGeneratedMedia;

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
        ?bool $canEdit = null,
        ?string $detectionSource = null,
        ?bool $hasAIGeneratedMedia = null,
    ): self {
        $self = new self;

        null !== $canEdit && $self['canEdit'] = $canEdit;
        null !== $detectionSource && $self['detectionSource'] = $detectionSource;
        null !== $hasAIGeneratedMedia && $self['hasAIGeneratedMedia'] = $hasAIGeneratedMedia;

        return $self;
    }

    /**
     * Whether the disclosure can be edited on X.
     */
    public function withCanEdit(bool $canEdit): self
    {
        $self = clone $this;
        $self['canEdit'] = $canEdit;

        return $self;
    }

    /**
     * Source of the AI-generated media disclosure.
     */
    public function withDetectionSource(string $detectionSource): self
    {
        $self = clone $this;
        $self['detectionSource'] = $detectionSource;

        return $self;
    }

    /**
     * True when X labels the tweet as containing AI-generated media.
     */
    public function withHasAIGeneratedMedia(bool $hasAIGeneratedMedia): self
    {
        $self = clone $this;
        $self['hasAIGeneratedMedia'] = $hasAIGeneratedMedia;

        return $self;
    }
}
