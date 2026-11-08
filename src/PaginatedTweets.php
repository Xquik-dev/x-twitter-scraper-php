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
use XTwitterScraper\PaginatedTweets\SearchContext;
use XTwitterScraper\PaginatedTweets\Skipped;

/**
 * No-mode search, user Tweet, user reply, and direct reply reads use automatic coverage. Shape, filters, aliases, and billing stay compatible. Unprefixed cursors remain legacy. Follow next_cursor while has_next_page is true. An empty filtered page can still have has_next_page true.
 *
 * @phpstan-import-type ImageFilterSummaryShape from ImageFilterSummary
 * @phpstan-import-type TopicFilterSummaryShape from TopicFilterSummary
 *
 * @phpstan-type PaginatedTweetsShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   tweets: list<mixed>,
 *   imageFilter?: null|ImageFilterSummary|ImageFilterSummaryShape,
 *   topicFilter?: null|TopicFilterSummary|TopicFilterSummaryShape,
 *   filteredCount?: int|null,
 *   readBackTo?: \DateTimeInterface|null,
 *   windowComplete?: bool|null,
 *   searchedQuery?: string|null,
 *   searchContext?: SearchContext|array<string,mixed>|null,
 *   skipped?: list<Skipped|array<string,mixed>>|null,
 * }
 */
final class PaginatedTweets implements BaseModel
{
    /** @use SdkModel<PaginatedTweetsShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<mixed> $tweets */
    #[Required(list: SearchTweet::class)]
    public array $tweets;

    /**
     * What the image filter asked & how many posts it kept. Present when you send imageShows.
     */
    #[Optional]
    public ?ImageFilterSummary $imageFilter;

    /**
     * What the topic filter asked & how many posts it kept. Present when you send topic.
     */
    #[Optional]
    public ?TopicFilterSummary $topicFilter;

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
     * Each `ids` entry that names no post, with why. Absent when every entry names a post.
     *
     * @var list<Skipped>|null $skipped
     */
    #[Optional(list: Skipped::class)]
    public ?array $skipped;

    /**
     * `new PaginatedTweets()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PaginatedTweets::with(hasNextPage: ..., nextCursor: ..., tweets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PaginatedTweets)
     *   ->withHasNextPage(...)
     *   ->withNextCursor(...)
     *   ->withTweets(...)
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
     * @param list<mixed> $tweets
     * @param ImageFilterSummary|ImageFilterSummaryShape|null $imageFilter
     * @param TopicFilterSummary|TopicFilterSummaryShape|null $topicFilter
     * @param SearchContext|array<string,mixed>|null $searchContext
     * @param list<Skipped|array<string,mixed>>|null $skipped
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $tweets,
        ImageFilterSummary|array|null $imageFilter = null,
        TopicFilterSummary|array|null $topicFilter = null,
        ?int $filteredCount = null,
        ?\DateTimeInterface $readBackTo = null,
        ?bool $windowComplete = null,
        ?string $searchedQuery = null,
        SearchContext|array|null $searchContext = null,
        ?array $skipped = null
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['tweets'] = $tweets;

        null !== $imageFilter && $self['imageFilter'] = $imageFilter;
        null !== $topicFilter && $self['topicFilter'] = $topicFilter;

        null !== $filteredCount && $self['filteredCount'] = $filteredCount;

        null !== $readBackTo && $self['readBackTo'] = $readBackTo;

        null !== $windowComplete && $self['windowComplete'] = $windowComplete;

        null !== $searchedQuery && $self['searchedQuery'] = $searchedQuery;

        null !== $searchContext && $self['searchContext'] = $searchContext;

        null !== $skipped && $self['skipped'] = $skipped;

        return $self;
    }

    public function withHasNextPage(bool $hasNextPage): self
    {
        $self = clone $this;
        $self['hasNextPage'] = $hasNextPage;

        return $self;
    }

    public function withNextCursor(string $nextCursor): self
    {
        $self = clone $this;
        $self['nextCursor'] = $nextCursor;

        return $self;
    }

    /**
     * @param list<mixed> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }

    /**
     * What the image filter asked & how many posts it kept. Present when you send imageShows.
     *
     * @param ImageFilterSummary|ImageFilterSummaryShape $imageFilter
     */
    public function withImageFilter(ImageFilterSummary|array $imageFilter): self
    {
        $self = clone $this;
        $self['imageFilter'] = $imageFilter;

        return $self;
    }

    /**
     * What the topic filter asked & how many posts it kept. Present when you send topic.
     *
     * @param TopicFilterSummary|TopicFilterSummaryShape $topicFilter
     */
    public function withTopicFilter(TopicFilterSummary|array $topicFilter): self
    {
        $self = clone $this;
        $self['topicFilter'] = $topicFilter;

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

    /**
     * Each `ids` entry that names no post, with why. Absent when every entry names a post.
     *
     * @param list<Skipped|array<string,mixed>>|null $skipped
     */
    public function withSkipped(?array $skipped): self
    {
        $self = clone $this;
        $self['skipped'] = $skipped;

        return $self;
    }
}
