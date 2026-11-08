<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSettings;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TargetsShape = array{
 *   name: string,
 *   aliases?: list<string>|null,
 * }
 */
final class Targets implements BaseModel
{
    /** @use SdkModel<TargetsShape> */
    use SdkModel;

    #[Required]
    public string $name;

    /**
     * @var list<string>|null $aliases
     */
    #[Optional(list: 'string')]
    public ?array $aliases;

    /**
     * `new Targets()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Targets::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Targets)->withName(...)
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
     * @param list<string>|null $aliases
     */
    public static function with(string $name, ?array $aliases = null): self
    {
        $self = new self;

        $self['name'] = $name;

        null !== $aliases && $self['aliases'] = $aliases;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param list<string>|null $aliases
     */
    public function withAliases(?array $aliases): self
    {
        $self = clone $this;
        $self['aliases'] = $aliases;

        return $self;
    }
}
