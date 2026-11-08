<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FollowerValueCountShape = array{
 *   count: int,
 *   percent: float,
 *   value: string,
 * }
 */
final class FollowerValueCount implements BaseModel
{
    /** @use SdkModel<FollowerValueCountShape> */
    use SdkModel;

    #[Required]
    public int $count;

    #[Required]
    public float $percent;

    #[Required]
    public string $value;

    /**
     * `new FollowerValueCount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FollowerValueCount::with(count: ..., percent: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FollowerValueCount)->withCount(...)->withPercent(...)->withValue(...)
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
    public static function with(int $count, float $percent, string $value): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['percent'] = $percent;
        $self['value'] = $value;

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

    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
