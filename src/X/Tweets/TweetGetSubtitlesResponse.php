<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetSubtitles;

/**
 * @phpstan-type TweetGetSubtitlesResponseShape = array{
 *   subtitles: TweetSubtitles|array<string,mixed>,
 * }
 */
final class TweetGetSubtitlesResponse implements BaseModel
{
    /** @use SdkModel<TweetGetSubtitlesResponseShape> */
    use SdkModel;

    /**
     * Holds the caption tracks of 1 tweet's videos.
     */
    #[Required]
    public TweetSubtitles $subtitles;

    /**
     * `new TweetGetSubtitlesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetGetSubtitlesResponse::with(subtitles: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetGetSubtitlesResponse)->withSubtitles(...)
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
     * @param TweetSubtitles|array<string,mixed> $subtitles
     */
    public static function with(TweetSubtitles|array $subtitles): self
    {
        $self = new self;

        $self['subtitles'] = $subtitles;

        return $self;
    }

    /**
     * Holds the caption tracks of 1 tweet's videos.
     *
     * @param TweetSubtitles|array<string,mixed> $subtitles
     */
    public function withSubtitles(TweetSubtitles|array $subtitles): self
    {
        $self = clone $this;
        $self['subtitles'] = $subtitles;

        return $self;
    }
}
