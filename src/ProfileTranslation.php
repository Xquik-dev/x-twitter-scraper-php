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
 * @phpstan-type ProfileTranslationShape = array{
 *   userID: string,
 *   userName: string,
 *   language: string,
 *   text: string,
 *   entities: TweetEntities|array<string,mixed>,
 *   sourceLanguage?: string|null,
 * }
 */
final class ProfileTranslation implements BaseModel
{
    /** @use SdkModel<ProfileTranslationShape> */
    use SdkModel;

    /**
     * ID of the account whose bio X translated.
     */
    #[Required('userId')]
    public string $userID;

    /**
     * Username of that account.
     */
    #[Required]
    public string $userName;

    /**
     * Language code of the translated bio, in lower case.
     */
    #[Required]
    public string $language;

    /**
     * Translated bio.
     */
    #[Required]
    public string $text;

    /**
     * Lists hashtags, symbols, links, and mentions from tweet text.
     */
    #[Required]
    public TweetEntities $entities;

    /**
     * Language code X detects in the bio, when it names one.
     */
    #[Optional]
    public ?string $sourceLanguage;

    /**
     * `new ProfileTranslation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ProfileTranslation::with(userID: ..., userName: ..., language: ..., text: ..., entities: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ProfileTranslation)->withUserID(...)->withUserName(...)->withLanguage(...)->withText(...)->withEntities(...)
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
    public static function with(string $userID, string $userName, string $language, string $text, TweetEntities|array $entities, ?string $sourceLanguage = null): self
    {
        $self = new self;

        $self['userID'] = $userID;
        $self['userName'] = $userName;
        $self['language'] = $language;
        $self['text'] = $text;
        $self['entities'] = $entities;

        null !== $sourceLanguage && $self['sourceLanguage'] = $sourceLanguage;

        return $self;
    }

    /**
     * ID of the account whose bio X translated.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * Username of that account.
     */
    public function withUserName(string $userName): self
    {
        $self = clone $this;
        $self['userName'] = $userName;

        return $self;
    }

    /**
     * Language code of the translated bio, in lower case.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Translated bio.
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
     * Language code X detects in the bio, when it names one.
     */
    public function withSourceLanguage(?string $sourceLanguage): self
    {
        $self = clone $this;
        $self['sourceLanguage'] = $sourceLanguage;

        return $self;
    }
}
