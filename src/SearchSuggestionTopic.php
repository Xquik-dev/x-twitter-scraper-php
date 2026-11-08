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
 * @phpstan-type SearchSuggestionTopicShape = array{
 *   topic: string,
 *   score?: float|null,
 *   tokens?: list<string>|null,
 *   inline?: bool|null,
 * }
 */
final class SearchSuggestionTopic implements BaseModel
{
    /** @use SdkModel<SearchSuggestionTopicShape> */
    use SdkModel;

    /**
     * Suggested search phrase.
     */
    #[Required]
    public string $topic;

    /**
     * X's rounded relevance score for the phrase.
     */
    #[Optional]
    public ?float $score;

    /**
     * Normalized text tokens X matches the phrase by.
     *
     * @var list<string>|null $tokens
     */
    #[Optional(list: 'string')]
    public ?array $tokens;

    /**
     * X's inline flag for the phrase.
     */
    #[Optional]
    public ?bool $inline;

    /**
     * `new SearchSuggestionTopic()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchSuggestionTopic::with(topic: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SearchSuggestionTopic)->withTopic(...)
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
    public static function with(string $topic, ?float $score = null, ?array $tokens = null, ?bool $inline = null): self
    {
        $self = new self;

        $self['topic'] = $topic;

        null !== $score && $self['score'] = $score;
        null !== $tokens && $self['tokens'] = $tokens;
        null !== $inline && $self['inline'] = $inline;

        return $self;
    }

    /**
     * Suggested search phrase.
     */
    public function withTopic(string $topic): self
    {
        $self = clone $this;
        $self['topic'] = $topic;

        return $self;
    }

    /**
     * X's rounded relevance score for the phrase.
     */
    public function withScore(?float $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    /**
     * Normalized text tokens X matches the phrase by.
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
     * X's inline flag for the phrase.
     */
    public function withInline(?bool $inline): self
    {
        $self = clone $this;
        $self['inline'] = $inline;

        return $self;
    }
}
