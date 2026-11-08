<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet\LimitedActions\Prompt;

/**
 * @phpstan-type LimitedActionsShape = array{
 *   action?: string|null,
 *   prompt?: Prompt|array<string,mixed>|null,
 * }
 */
final class LimitedActions implements BaseModel
{
    /** @use SdkModel<LimitedActionsShape> */
    use SdkModel;

    #[Optional]
    public ?string $action;

    #[Optional]
    public ?Prompt $prompt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Prompt|array<string,mixed>|null $prompt
     */
    public static function with(?string $action = null, Prompt|array|null $prompt = null): self
    {
        $self = new self;

        null !== $action && $self['action'] = $action;
        null !== $prompt && $self['prompt'] = $prompt;

        return $self;
    }

    public function withAction(?string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * @param Prompt|array<string,mixed>|null $prompt
     */
    public function withPrompt(Prompt|array|null $prompt): self
    {
        $self = clone $this;
        $self['prompt'] = $prompt;

        return $self;
    }
}
