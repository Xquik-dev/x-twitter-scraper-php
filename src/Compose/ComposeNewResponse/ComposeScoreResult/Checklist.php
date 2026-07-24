<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ChecklistShape = array{
 *   factor: string, passed: bool, suggestion?: string|null
 * }
 */
final class Checklist implements BaseModel
{
    /** @use SdkModel<ChecklistShape> */
    use SdkModel;

    #[Required]
    public string $factor;

    #[Required]
    public bool $passed;

    /**
     * Present only when the check fails.
     */
    #[Optional]
    public ?string $suggestion;

    /**
     * `new Checklist()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Checklist::with(factor: ..., passed: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Checklist)->withFactor(...)->withPassed(...)
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
    public static function with(
        string $factor,
        bool $passed,
        ?string $suggestion = null
    ): self {
        $self = new self;

        $self['factor'] = $factor;
        $self['passed'] = $passed;

        null !== $suggestion && $self['suggestion'] = $suggestion;

        return $self;
    }

    public function withFactor(string $factor): self
    {
        $self = clone $this;
        $self['factor'] = $factor;

        return $self;
    }

    public function withPassed(bool $passed): self
    {
        $self = clone $this;
        $self['passed'] = $passed;

        return $self;
    }

    /**
     * Present only when the check fails.
     */
    public function withSuggestion(string $suggestion): self
    {
        $self = clone $this;
        $self['suggestion'] = $suggestion;

        return $self;
    }
}
