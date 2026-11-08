<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\AccountBasedIn\Level;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type AccountBasedInShape = array{
 *   value: string,
 *   level: Level|value-of<Level>,
 *   observedAt: \DateTimeInterface,
 * }
 */
final class AccountBasedIn implements BaseModel
{
    /** @use SdkModel<AccountBasedInShape> */
    use SdkModel;

    #[Required]
    public string $value;

    /**
     * @var value-of<Level> $level
     */
    #[Required(enum: Level::class)]
    public string $level;

    #[Required]
    public \DateTimeInterface $observedAt;

    /**
     * `new AccountBasedIn()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AccountBasedIn::with(value: ..., level: ..., observedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AccountBasedIn)->withValue(...)->withLevel(...)->withObservedAt(...)
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
     *
     * @param Level|value-of<Level> $level
     */
    public static function with(string $value, Level|string $level, \DateTimeInterface $observedAt): self
    {
        $self = new self;

        $self['value'] = $value;
        $self['level'] = $level;
        $self['observedAt'] = $observedAt;

        return $self;
    }

    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }

    /**
     * @param Level|value-of<Level> $level
     */
    public function withLevel(Level|string $level): self
    {
        $self = clone $this;
        $self['level'] = $level;

        return $self;
    }

    public function withObservedAt(\DateTimeInterface $observedAt): self
    {
        $self = clone $this;
        $self['observedAt'] = $observedAt;

        return $self;
    }
}
