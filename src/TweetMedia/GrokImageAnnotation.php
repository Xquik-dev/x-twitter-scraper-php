<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetMedia;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type GrokImageAnnotationShape = array{
 *   prompt?: string|null,
 *   upsampledPrompt?: string|null,
 * }
 */
final class GrokImageAnnotation implements BaseModel
{
    /** @use SdkModel<GrokImageAnnotationShape> */
    use SdkModel;

    /**
     * Prompt the image came from.
     */
    #[Optional]
    public ?string $prompt;

    /**
     * Grok's longer rewrite of the prompt.
     */
    #[Optional]
    public ?string $upsampledPrompt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $prompt = null, ?string $upsampledPrompt = null): self
    {
        $self = new self;

        null !== $prompt && $self['prompt'] = $prompt;
        null !== $upsampledPrompt && $self['upsampledPrompt'] = $upsampledPrompt;

        return $self;
    }

    /**
     * Prompt the image came from.
     */
    public function withPrompt(?string $prompt): self
    {
        $self = clone $this;
        $self['prompt'] = $prompt;

        return $self;
    }

    /**
     * Grok's longer rewrite of the prompt.
     */
    public function withUpsampledPrompt(?string $upsampledPrompt): self
    {
        $self = clone $this;
        $self['upsampledPrompt'] = $upsampledPrompt;

        return $self;
    }
}
