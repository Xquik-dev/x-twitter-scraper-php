<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\TweetAnalysisSummary\Cashtags;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SignalShape = array{
 *   bullish: int,
 *   bearish: int,
 *   score: float,
 * }
 */
final class Signal implements BaseModel
{
    /** @use SdkModel<SignalShape> */
    use SdkModel;

    #[Required]
    public int $bullish;

    #[Required]
    public int $bearish;

    /**
     * Bullish minus bearish posts, over all posts.
     */
    #[Required]
    public float $score;

    /**
     * `new Signal()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Signal::with(bullish: ..., bearish: ..., score: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Signal)->withBullish(...)->withBearish(...)->withScore(...)
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
    public static function with(int $bullish, int $bearish, float $score): self
    {
        $self = new self;

        $self['bullish'] = $bullish;
        $self['bearish'] = $bearish;
        $self['score'] = $score;

        return $self;
    }

    public function withBullish(int $bullish): self
    {
        $self = clone $this;
        $self['bullish'] = $bullish;

        return $self;
    }

    public function withBearish(int $bearish): self
    {
        $self = clone $this;
        $self['bearish'] = $bearish;

        return $self;
    }

    /**
     * Bullish minus bearish posts, over all posts.
     */
    public function withScore(float $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }
}
