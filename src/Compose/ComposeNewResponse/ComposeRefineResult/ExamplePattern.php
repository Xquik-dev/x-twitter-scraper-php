<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExamplePatternShape = array{description: string, pattern: string}
 */
final class ExamplePattern implements BaseModel
{
    /** @use SdkModel<ExamplePatternShape> */
    use SdkModel;

    #[Required]
    public string $description;

    #[Required]
    public string $pattern;

    /**
     * `new ExamplePattern()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExamplePattern::with(description: ..., pattern: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExamplePattern)->withDescription(...)->withPattern(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $description, string $pattern): self
    {
        $self = new self;

        $self['description'] = $description;
        $self['pattern'] = $pattern;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withPattern(string $pattern): self
    {
        $self = clone $this;
        $self['pattern'] = $pattern;

        return $self;
    }
}
