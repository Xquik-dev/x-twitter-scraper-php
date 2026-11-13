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
use XTwitterScraper\SportsGamePosts\SearchContext;

/**
 * @phpstan-type SportsGamePostsShape = array{
 *   tweets: list<SearchTweet2|array<string,mixed>>,
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   query: string|null,
 *   filteredCount?: int|null,
 *   readBackTo?: \DateTimeInterface|null,
 *   hiddenTimeline?: bool|null,
 *   windowComplete?: bool|null,
 *   searchedQuery?: string|null,
 *   searchContext?: SearchContext|array<string,mixed>|null,
 * }
 */
final class SportsGamePosts implements BaseModel
{
    /** @use SdkModel<SportsGamePostsShape> */
    use SdkModel;

    /**
     * @var list<SearchTweet2> $tweets
     */
    #[Required(list: SearchTweet2::class)]
    public array $tweets;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    #[Required('next_cursor')]
    public string $nextCursor;

    /**
     * An X search for this game's posts, in the order asked. Send it to GET /x/tweets/search for more filters. Null when no search is available.
     */
    #[Required]
    public ?string $query;

    /**
     * Whole number from 0.
     */
    #[Optional('filtered_count')]
    public ?int $filteredCount;

    /**
     * The UTC time this filtered search has reached.
     */
    #[Optional]
    public ?\DateTimeInterface $readBackTo;

    /**
     * Present on an empty last page when X shows this account's timeline to nobody. The page is empty because of that, so it doesn't mean the account posted nothing. A retry returns the same page.
     */
    #[Optional]
    public ?bool $hiddenTimeline;

    /**
     * Present on a last page whose sources all read past its start time.
     */
    #[Optional]
    public ?bool $windowComplete;

    /**
     * The query that ran, when it differs from your q.
     */
    #[Optional]
    public ?string $searchedQuery;

    /**
     * What X shows beside a search's posts, the same for everyone. Present on a search for a cashtag X has a card for, such as $BTC. Cashtag searches add X's ticker card in `searchContext`.
     */
    #[Optional]
    public ?SearchContext $searchContext;

    /**
     * `new SportsGamePosts()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SportsGamePosts::with(tweets: ..., hasNextPage: ..., nextCursor: ..., query: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SportsGamePosts)->withTweets(...)->withHasNextPage(...)->withNextCursor(...)->withQuery(...)
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
     * @param list<SearchTweet2|array<string,mixed>> $tweets
     * @param SearchContext|array<string,mixed>|null $searchContext
     */
    public static function with(array $tweets, bool $hasNextPage, string $nextCursor, ?string $query, ?int $filteredCount = null, ?\DateTimeInterface $readBackTo = null, ?bool $hiddenTimeline = null, ?bool $windowComplete = null, ?string $searchedQuery = null, SearchContext|array|null $searchContext = null): self
    {
        $self = new self;

        $self['tweets'] = $tweets;
        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['query'] = $query;

        null !== $filteredCount && $self['filteredCount'] = $filteredCount;
        null !== $readBackTo && $self['readBackTo'] = $readBackTo;
        null !== $hiddenTimeline && $self['hiddenTimeline'] = $hiddenTimeline;
        null !== $windowComplete && $self['windowComplete'] = $windowComplete;
        null !== $searchedQuery && $self['searchedQuery'] = $searchedQuery;
        null !== $searchContext && $self['searchContext'] = $searchContext;

        return $self;
    }

    /**
     * @param list<SearchTweet2|array<string,mixed>> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    /**
     * Cursor for the next page. Send it unchanged. Each next page arrives fast.
     */
    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * An X search for this game's posts, in the order asked. Send it to GET /x/tweets/search for more filters. Null when no search is available.
     */
    public function withQuery(?string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withFilteredCount(?int $filteredCount): self
    {
        $self = clone $this;
        $self['filteredCount'] = $filteredCount;

        return $self;
    }

    /**
     * The UTC time this filtered search has reached.
     */
    public function withReadBackTo(?\DateTimeInterface $readBackTo): self
    {
        $self = clone $this;
        $self['readBackTo'] = $readBackTo;

        return $self;
    }

    /**
     * Present on an empty last page when X shows this account's timeline to nobody. The page is empty because of that, so it doesn't mean the account posted nothing. A retry returns the same page.
     */
    public function withHiddenTimeline(?bool $hiddenTimeline): self
    {
        $self = clone $this;
        $self['hiddenTimeline'] = $hiddenTimeline;

        return $self;
    }

    /**
     * Present on a last page whose sources all read past its start time.
     */
    public function withWindowComplete(?bool $windowComplete): self
    {
        $self = clone $this;
        $self['windowComplete'] = $windowComplete;

        return $self;
    }

    /**
     * The query that ran, when it differs from your q.
     */
    public function withSearchedQuery(?string $searchedQuery): self
    {
        $self = clone $this;
        $self['searchedQuery'] = $searchedQuery;

        return $self;
    }

    /**
     * What X shows beside a search's posts, the same for everyone. Present on a search for a cashtag X has a card for, such as $BTC. Cashtag searches add X's ticker card in `searchContext`.
     *
     * @param SearchContext|array<string,mixed>|null $searchContext
     */
    public function withSearchContext(SearchContext|array|null $searchContext): self
    {
        $self = clone $this;
        $self['searchContext'] = $searchContext;

        return $self;
    }
}
