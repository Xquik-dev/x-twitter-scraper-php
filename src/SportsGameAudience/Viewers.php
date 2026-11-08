<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\SportsGameAudience;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ViewersShape = array{
 *   count: int,
 *   asOf: \DateTimeInterface,
 * }
 */
final class Viewers implements BaseModel
{
    /** @use SdkModel<ViewersShape> */
    use SdkModel;

    /**
     * How many people watched the game on X.
     */
    #[Required]
    public int $count;

    /**
     * When X counted them.
     */
    #[Required]
    public \DateTimeInterface $asOf;

    /**
     * `new Viewers()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Viewers::with(count: ..., asOf: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Viewers)->withCount(...)->withAsOf(...)
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
    public static function with(int $count, \DateTimeInterface $asOf): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['asOf'] = $asOf;

        return $self;
    }

    /**
     * How many people watched the game on X.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * When X counted them.
     */
    public function withAsOf(\DateTimeInterface $asOf): self
    {
        $self = clone $this;
        $self['asOf'] = $asOf;

        return $self;
    }
}
