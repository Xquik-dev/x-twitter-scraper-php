<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetEmbedShape = array{
 *   tweetID: string,
 *   url: string,
 *   authorName: string,
 *   authorUrl: string,
 *   html: string,
 *   width?: int|null,
 *   height?: int|null,
 * }
 */
final class TweetEmbed implements BaseModel
{
    /** @use SdkModel<TweetEmbedShape> */
    use SdkModel;

    /**
     * ID of the embedded tweet.
     */
    #[Required('tweetId')]
    public string $tweetID;

    /**
     * Link to the tweet with its author's username.
     */
    #[Required]
    public string $url;

    /**
     * Display name of the tweet's author.
     */
    #[Required]
    public string $authorName;

    /**
     * Link to the author's profile.
     */
    #[Required]
    public string $authorUrl;

    /**
     * Markup to place on a page. It loads X's widget script unless `omitScript` is `true`.
     */
    #[Required]
    public string $html;

    /**
     * Width of the embed in pixels.
     */
    #[Optional]
    public ?int $width;

    /**
     * Height in pixels, when X fixes it.
     */
    #[Optional]
    public ?int $height;

    /**
     * `new TweetEmbed()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetEmbed::with(tweetID: ..., url: ..., authorName: ..., authorUrl: ..., html: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetEmbed)->withTweetID(...)->withUrl(...)->withAuthorName(...)->withAuthorUrl(...)->withHtml(...)
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
    public static function with(string $tweetID, string $url, string $authorName, string $authorUrl, string $html, ?int $width = null, ?int $height = null): self
    {
        $self = new self;

        $self['tweetID'] = $tweetID;
        $self['url'] = $url;
        $self['authorName'] = $authorName;
        $self['authorUrl'] = $authorUrl;
        $self['html'] = $html;

        null !== $width && $self['width'] = $width;
        null !== $height && $self['height'] = $height;

        return $self;
    }

    /**
     * ID of the embedded tweet.
     */
    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * Link to the tweet with its author's username.
     */
    public function withUrl(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Display name of the tweet's author.
     */
    public function withAuthorName(string $authorName): self
    {
        $self = clone $this;
        $self['authorName'] = $authorName;

        return $self;
    }

    /**
     * Link to the author's profile.
     */
    public function withAuthorUrl(string $authorUrl): self
    {
        $self = clone $this;
        $self['authorUrl'] = $authorUrl;

        return $self;
    }

    /**
     * Markup to place on a page. It loads X's widget script unless `omitScript` is `true`.
     */
    public function withHtml(string $html): self
    {
        $self = clone $this;
        $self['html'] = $html;

        return $self;
    }

    /**
     * Width of the embed in pixels.
     */
    public function withWidth(?int $width): self
    {
        $self = clone $this;
        $self['width'] = $width;

        return $self;
    }

    /**
     * Height in pixels, when X fixes it.
     */
    public function withHeight(?int $height): self
    {
        $self = clone $this;
        $self['height'] = $height;

        return $self;
    }
}
