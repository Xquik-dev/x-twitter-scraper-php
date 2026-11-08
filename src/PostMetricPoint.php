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
 * @phpstan-type PostMetricPointShape = array{
 *   value: int|null,
 *   gain: int|null,
 * }
 */
final class PostMetricPoint implements BaseModel
{
    /** @use SdkModel<PostMetricPointShape> */
    use SdkModel;

    #[Required]
    public ?int $value;

    #[Required]
    public ?int $gain;

    /**
     * `new PostMetricPoint()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PostMetricPoint::with(value: ..., gain: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PostMetricPoint)->withValue(...)->withGain(...)
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
    public static function with(?int $value, ?int $gain): self
    {
        $self = new self;

        $self['value'] = $value;
        $self['gain'] = $gain;

        return $self;
    }

    public function withValue(?int $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }

    public function withGain(?int $gain): self
    {
        $self = clone $this;
        $self['gain'] = $gain;

        return $self;
    }
}
