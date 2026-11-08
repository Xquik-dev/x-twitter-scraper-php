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
 * @phpstan-type SearchSuggestionHashtagShape = array{
 *   hashtag: string,
 *   score?: float|null,
 *   tokens?: list<string>|null,
 *   inline?: bool|null,
 * }
 */
final class SearchSuggestionHashtag implements BaseModel
{
    /** @use SdkModel<SearchSuggestionHashtagShape> */
    use SdkModel;

    /**
     * Suggested hashtag, with its leading #.
     */
    #[Required]
    public string $hashtag;

    /**
     * X's rounded relevance score for the hashtag.
     */
    #[Optional]
    public ?float $score;

    /**
     * Normalized text tokens X matches the hashtag by.
     *
     * @var list<string>|null $tokens
     */
    #[Optional(list: 'string')]
    public ?array $tokens;

    /**
     * X's inline flag for the hashtag.
     */
    #[Optional]
    public ?bool $inline;

    /**
     * `new SearchSuggestionHashtag()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchSuggestionHashtag::with(hashtag: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SearchSuggestionHashtag)->withHashtag(...)
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
     * @param list<string>|null $tokens
     */
    public static function with(string $hashtag, ?float $score = null, ?array $tokens = null, ?bool $inline = null): self
    {
        $self = new self;

        $self['hashtag'] = $hashtag;

        null !== $score && $self['score'] = $score;
        null !== $tokens && $self['tokens'] = $tokens;
        null !== $inline && $self['inline'] = $inline;

        return $self;
    }

    /**
     * Suggested hashtag, with its leading #.
     */
    public function withHashtag(string $hashtag): self
    {
        $self = clone $this;
        $self['hashtag'] = $hashtag;

        return $self;
    }

    /**
     * X's rounded relevance score for the hashtag.
     */
    public function withScore(?float $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    /**
     * Normalized text tokens X matches the hashtag by.
     *
     * @param list<string>|null $tokens
     */
    public function withTokens(?array $tokens): self
    {
        $self = clone $this;
        $self['tokens'] = $tokens;

        return $self;
    }

    /**
     * X's inline flag for the hashtag.
     */
    public function withInline(?bool $inline): self
    {
        $self = clone $this;
        $self['inline'] = $inline;

        return $self;
    }
}
