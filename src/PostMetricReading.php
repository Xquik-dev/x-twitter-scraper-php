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
 * @phpstan-type PostMetricReadingShape = array{
 *   current: int|null,
 *   gain: int|null,
 * }
 */
final class PostMetricReading implements BaseModel
{
    /** @use SdkModel<PostMetricReadingShape> */
    use SdkModel;

    #[Required]
    public ?int $current;

    #[Required]
    public ?int $gain;

    /**
     * `new PostMetricReading()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostMetricReading::with(current: ..., gain: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostMetricReading)->withCurrent(...)->withGain(...)
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
    public static function with(?int $current, ?int $gain): self
    {
        $self = new self;

        $self['current'] = $current;
        $self['gain'] = $gain;

        return $self;
    }

    public function withCurrent(?int $current): self
    {
        $self = clone $this;
        $self['current'] = $current;

        return $self;
    }

    public function withGain(?int $gain): self
    {
        $self = clone $this;
        $self['gain'] = $gain;

        return $self;
    }
}
