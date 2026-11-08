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
 * @phpstan-type TweetSubtitlesShape = array{
 *   tweetID: string,
 *   tracks: list<SubtitleTrack|array<string,mixed>>,
 * }
 */
final class TweetSubtitles implements BaseModel
{
    /** @use SdkModel<TweetSubtitlesShape> */
    use SdkModel;

    /**
     * ID of the tweet.
     */
    #[Required('tweetId')]
    public string $tweetID;

    /**
     * Caption tracks, empty when no video has captions.
     *
     * @var list<SubtitleTrack> $tracks
     */
    #[Required(list: SubtitleTrack::class)]
    public array $tracks;

    /**
     * `new TweetSubtitles()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetSubtitles::with(tweetID: ..., tracks: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetSubtitles)->withTweetID(...)->withTracks(...)
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
     * @param list<SubtitleTrack|array<string,mixed>> $tracks
     */
    public static function with(string $tweetID, array $tracks): self
    {
        $self = new self;

        $self['tweetID'] = $tweetID;
        $self['tracks'] = $tracks;

        return $self;
    }

    /**
     * ID of the tweet.
     */
    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * Caption tracks, empty when no video has captions.
     *
     * @param list<SubtitleTrack|array<string,mixed>> $tracks
     */
    public function withTracks(array $tracks): self
    {
        $self = clone $this;
        $self['tracks'] = $tracks;

        return $self;
    }
}
