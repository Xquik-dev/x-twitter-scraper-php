<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetDetail;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextHighlightsShape = array{
 *   startIndex: int,
 *   endIndex: int,
 * }
 */
final class TextHighlights implements BaseModel
{
    /** @use SdkModel<TextHighlightsShape> */
    use SdkModel;

    /**
     * The first code point of the match.
     */
    #[Required]
    public int $startIndex;

    /**
     * The first code point after the match.
     */
    #[Required]
    public int $endIndex;

    /**
     * `new TextHighlights()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextHighlights::with(startIndex: ..., endIndex: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextHighlights)->withStartIndex(...)->withEndIndex(...)
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
    public static function with(int $startIndex, int $endIndex): self
    {
        $self = new self;

        $self['startIndex'] = $startIndex;
        $self['endIndex'] = $endIndex;

        return $self;
    }

    /**
     * The first code point of the match.
     */
    public function withStartIndex(int $startIndex): self
    {
        $self = clone $this;
        $self['startIndex'] = $startIndex;

        return $self;
    }

    /**
     * The first code point after the match.
     */
    public function withEndIndex(int $endIndex): self
    {
        $self = clone $this;
        $self['endIndex'] = $endIndex;

        return $self;
    }
}
