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
 * @phpstan-type TweetEntitiesShape = array{
 *   hashtags?: list<TweetHashtag|array<string,mixed>>|null,
 *   smarttags?: list<TweetSymbol|array<string,mixed>>|null,
 *   symbols?: list<TweetSymbol|array<string,mixed>>|null,
 *   timestamps?: list<TweetSymbol|array<string,mixed>>|null,
 *   urls?: list<TweetUrlEntity|array<string,mixed>>|null,
 *   userMentions?: list<TweetUserMention|array<string,mixed>>|null,
 * }
 */
final class TweetEntities implements BaseModel
{
    /** @use SdkModel<TweetEntitiesShape> */
    use SdkModel;

    /**
     * @var list<TweetHashtag>|null $hashtags
     */
    #[Optional(list: TweetHashtag::class)]
    public ?array $hashtags;

    /**
     * @var list<TweetSymbol>|null $smarttags
     */
    #[Optional(list: TweetSymbol::class)]
    public ?array $smarttags;

    /**
     * @var list<TweetSymbol>|null $symbols
     */
    #[Optional(list: TweetSymbol::class)]
    public ?array $symbols;

    /**
     * @var list<TweetSymbol>|null $timestamps
     */
    #[Optional(list: TweetSymbol::class)]
    public ?array $timestamps;

    /**
     * @var list<TweetUrlEntity>|null $urls
     */
    #[Optional(list: TweetUrlEntity::class)]
    public ?array $urls;

    /**
     * @var list<TweetUserMention>|null $userMentions
     */
    #[Optional('user_mentions', list: TweetUserMention::class)]
    public ?array $userMentions;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<TweetHashtag|array<string,mixed>>|null $hashtags
     * @param list<TweetSymbol|array<string,mixed>>|null $smarttags
     * @param list<TweetSymbol|array<string,mixed>>|null $symbols
     * @param list<TweetSymbol|array<string,mixed>>|null $timestamps
     * @param list<TweetUrlEntity|array<string,mixed>>|null $urls
     * @param list<TweetUserMention|array<string,mixed>>|null $userMentions
     */
    public static function with(?array $hashtags = null, ?array $smarttags = null, ?array $symbols = null, ?array $timestamps = null, ?array $urls = null, ?array $userMentions = null): self
    {
        $self = new self;

        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $smarttags && $self['smarttags'] = $smarttags;
        null !== $symbols && $self['symbols'] = $symbols;
        null !== $timestamps && $self['timestamps'] = $timestamps;
        null !== $urls && $self['urls'] = $urls;
        null !== $userMentions && $self['userMentions'] = $userMentions;

        return $self;
    }

    /**
     * @param list<TweetHashtag|array<string,mixed>>|null $hashtags
     */
    public function withHashtags(?array $hashtags): self
    {
        $self = clone $this;
        $self['hashtags'] = $hashtags;

        return $self;
    }

    /**
     * @param list<TweetSymbol|array<string,mixed>>|null $smarttags
     */
    public function withSmarttags(?array $smarttags): self
    {
        $self = clone $this;
        $self['smarttags'] = $smarttags;

        return $self;
    }

    /**
     * @param list<TweetSymbol|array<string,mixed>>|null $symbols
     */
    public function withSymbols(?array $symbols): self
    {
        $self = clone $this;
        $self['symbols'] = $symbols;

        return $self;
    }

    /**
     * @param list<TweetSymbol|array<string,mixed>>|null $timestamps
     */
    public function withTimestamps(?array $timestamps): self
    {
        $self = clone $this;
        $self['timestamps'] = $timestamps;

        return $self;
    }

    /**
     * @param list<TweetUrlEntity|array<string,mixed>>|null $urls
     */
    public function withUrls(?array $urls): self
    {
        $self = clone $this;
        $self['urls'] = $urls;

        return $self;
    }

    /**
     * @param list<TweetUserMention|array<string,mixed>>|null $userMentions
     */
    public function withUserMentions(?array $userMentions): self
    {
        $self = clone $this;
        $self['userMentions'] = $userMentions;

        return $self;
    }
}
