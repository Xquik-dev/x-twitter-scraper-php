<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\FootballPlayerStats;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ExtraPointsShape = array{
 *   attempts: int|null,
 *   made: int|null,
 * }
 */
final class ExtraPoints implements BaseModel
{
    /** @use SdkModel<ExtraPointsShape> */
    use SdkModel;

    /**
     * Extra points tried.
     */
    #[Required]
    public ?int $attempts;

    /**
     * Extra points made.
     */
    #[Required]
    public ?int $made;

    /**
     * `new ExtraPoints()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtraPoints::with(attempts: ..., made: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtraPoints)->withAttempts(...)->withMade(...)
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
    public static function with(?int $attempts, ?int $made): self
    {
        $self = new self;

        $self['attempts'] = $attempts;
        $self['made'] = $made;

        return $self;
    }

    /**
     * Extra points tried.
     */
    public function withAttempts(?int $attempts): self
    {
        $self = clone $this;
        $self['attempts'] = $attempts;

        return $self;
    }

    /**
     * Extra points made.
     */
    public function withMade(?int $made): self
    {
        $self = clone $this;
        $self['made'] = $made;

        return $self;
    }
}
