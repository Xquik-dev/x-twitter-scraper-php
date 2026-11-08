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
 * @phpstan-type SearchSuggestionsShape = array{
 *   query: string,
 *   users: list<SearchSuggestionUser|array<string,mixed>>,
 *   topics: list<SearchSuggestionTopic|array<string,mixed>>,
 *   hashtags: list<SearchSuggestionHashtag|array<string,mixed>>,
 *   cashtags: list<SearchSuggestionCashtag|array<string,mixed>>,
 *   count: int,
 * }
 */
final class SearchSuggestions implements BaseModel
{
    /** @use SdkModel<SearchSuggestionsShape> */
    use SdkModel;

    /**
     * The query you sent, trimmed.
     */
    #[Required]
    public string $query;

    /**
     * Suggested accounts.
     *
     * @var list<SearchSuggestionUser> $users
     */
    #[Required(list: SearchSuggestionUser::class)]
    public array $users;

    /**
     * Suggested search phrases that are not hashtags.
     *
     * @var list<SearchSuggestionTopic> $topics
     */
    #[Required(list: SearchSuggestionTopic::class)]
    public array $topics;

    /**
     * Suggested hashtags.
     *
     * @var list<SearchSuggestionHashtag> $hashtags
     */
    #[Required(list: SearchSuggestionHashtag::class)]
    public array $hashtags;

    /**
     * Suggested stocks & crypto tokens.
     *
     * @var list<SearchSuggestionCashtag> $cashtags
     */
    #[Required(list: SearchSuggestionCashtag::class)]
    public array $cashtags;

    /**
     * Suggestions returned across all 4 lists. Each costs 1 credit.
     */
    #[Required]
    public int $count;

    /**
     * `new SearchSuggestions()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchSuggestions::with(query: ..., users: ..., topics: ..., hashtags: ..., cashtags: ..., count: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SearchSuggestions)->withQuery(...)->withUsers(...)->withTopics(...)->withHashtags(...)->withCashtags(...)->withCount(...)
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
     * @param list<SearchSuggestionUser|array<string,mixed>> $users
     * @param list<SearchSuggestionTopic|array<string,mixed>> $topics
     * @param list<SearchSuggestionHashtag|array<string,mixed>> $hashtags
     * @param list<SearchSuggestionCashtag|array<string,mixed>> $cashtags
     */
    public static function with(string $query, array $users, array $topics, array $hashtags, array $cashtags, int $count): self
    {
        $self = new self;

        $self['query'] = $query;
        $self['users'] = $users;
        $self['topics'] = $topics;
        $self['hashtags'] = $hashtags;
        $self['cashtags'] = $cashtags;
        $self['count'] = $count;

        return $self;
    }

    /**
     * The query you sent, trimmed.
     */
    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * Suggested accounts.
     *
     * @param list<SearchSuggestionUser|array<string,mixed>> $users
     */
    public function withUsers(array $users): self
    {
        $self = clone $this;
        $self['users'] = $users;

        return $self;
    }

    /**
     * Suggested search phrases that are not hashtags.
     *
     * @param list<SearchSuggestionTopic|array<string,mixed>> $topics
     */
    public function withTopics(array $topics): self
    {
        $self = clone $this;
        $self['topics'] = $topics;

        return $self;
    }

    /**
     * Suggested hashtags.
     *
     * @param list<SearchSuggestionHashtag|array<string,mixed>> $hashtags
     */
    public function withHashtags(array $hashtags): self
    {
        $self = clone $this;
        $self['hashtags'] = $hashtags;

        return $self;
    }

    /**
     * Suggested stocks & crypto tokens.
     *
     * @param list<SearchSuggestionCashtag|array<string,mixed>> $cashtags
     */
    public function withCashtags(array $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * Suggestions returned across all 4 lists. Each costs 1 credit.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }
}
