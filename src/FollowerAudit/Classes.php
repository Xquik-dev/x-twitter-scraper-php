<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FollowerAudit;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\FollowerClass;

/**
 * @phpstan-type ClassesShape = array{
 *   class: FollowerClass|value-of<FollowerClass>,
 *   count: int,
 *   percent: float,
 * }
 */
final class Classes implements BaseModel
{
    /** @use SdkModel<ClassesShape> */
    use SdkModel;

    /**
     * What 1 follower looks like from its public profile.
     *
     * @var value-of<FollowerClass> $class
     */
    #[Required(enum: FollowerClass::class)]
    public string $class;

    #[Required]
    public int $count;

    #[Required]
    public float $percent;

    /**
     * `new Classes()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Classes::with(class: ..., count: ..., percent: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Classes)->withClass(...)->withCount(...)->withPercent(...)
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
     * @param FollowerClass|value-of<FollowerClass> $class
     */
    public static function with(FollowerClass|string $class, int $count, float $percent): self
    {
        $self = new self;

        $self['class'] = $class;
        $self['count'] = $count;
        $self['percent'] = $percent;

        return $self;
    }

    /**
     * What 1 follower looks like from its public profile.
     *
     * @param FollowerClass|value-of<FollowerClass> $class
     */
    public function withClass(FollowerClass|string $class): self
    {
        $self = clone $this;
        $self['class'] = $class;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    public function withPercent(float $percent): self
    {
        $self = clone $this;
        $self['percent'] = $percent;

        return $self;
    }
}
