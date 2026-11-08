<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FollowerAudit;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SignalsShape = array{
 *   count: int,
 *   id: string,
 *   percent: float,
 *   points: int,
 * }
 */
final class Signals implements BaseModel
{
    /** @use SdkModel<SignalsShape> */
    use SdkModel;

    #[Required]
    public int $count;

    #[Required]
    public string $id;

    #[Required]
    public float $percent;

    #[Required]
    public int $points;

    /**
     * `new Signals()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Signals::with(count: ..., id: ..., percent: ..., points: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Signals)->withCount(...)->withId(...)->withPercent(...)->withPoints(...)
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
    public static function with(int $count, string $id, float $percent, int $points): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['id'] = $id;
        $self['percent'] = $percent;
        $self['points'] = $points;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withPercent(float $percent): self
    {
        $self = clone $this;
        $self['percent'] = $percent;

        return $self;
    }

    public function withPoints(int $points): self
    {
        $self = clone $this;
        $self['points'] = $points;

        return $self;
    }
}
