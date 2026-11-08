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
 * @phpstan-type TweetTranslationShape = array{
 *   tweetID: string,
 *   language: string,
 *   text: string,
 *   entities: TweetEntities|array<string,mixed>,
 *   sourceLanguage?: string|null,
 * }
 */
final class TweetTranslation implements BaseModel
{
    /** @use SdkModel<TweetTranslationShape> */
    use SdkModel;

    /**
     * ID of the translated tweet.
     */
    #[Required('tweetId')]
    public string $tweetID;

    /**
     * Language code of the translated text, in lower case.
     */
    #[Required]
    public string $language;

    /**
     * Translated tweet text.
     */
    #[Required]
    public string $text;

    /**
     * Lists hashtags, symbols, links, and mentions from tweet text.
     */
    #[Required]
    public TweetEntities $entities;

    /**
     * Language code X detects in the tweet, when it names one.
     */
    #[Optional]
    public ?string $sourceLanguage;

    /**
     * `new TweetTranslation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetTranslation::with(tweetID: ..., language: ..., text: ..., entities: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetTranslation)->withTweetID(...)->withLanguage(...)->withText(...)->withEntities(...)
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
     * @param TweetEntities|array<string,mixed> $entities
     */
    public static function with(string $tweetID, string $language, string $text, TweetEntities|array $entities, ?string $sourceLanguage = null): self
    {
        $self = new self;

        $self['tweetID'] = $tweetID;
        $self['language'] = $language;
        $self['text'] = $text;
        $self['entities'] = $entities;

        null !== $sourceLanguage && $self['sourceLanguage'] = $sourceLanguage;

        return $self;
    }

    /**
     * ID of the translated tweet.
     */
    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * Language code of the translated text, in lower case.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Translated tweet text.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Lists hashtags, symbols, links, and mentions from tweet text.
     *
     * @param TweetEntities|array<string,mixed> $entities
     */
    public function withEntities(TweetEntities|array $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    /**
     * Language code X detects in the tweet, when it names one.
     */
    public function withSourceLanguage(?string $sourceLanguage): self
    {
        $self = clone $this;
        $self['sourceLanguage'] = $sourceLanguage;

        return $self;
    }
}
