<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\SearchContext;

/**
 * Direct reply rows. No-mode requests use resumable automatic coverage. Complete mode also returns nested replies and coverage diagnostics. Keep nested replies separate from direct coverage.
 *
 * @phpstan-import-type DiagnosticShape from Diagnostic
 *
 * @phpstan-type TweetGetRepliesResponseShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   tweets: list<mixed>,
 *   diagnostic?: null|Diagnostic|DiagnosticShape,
 *   nestedReplies?: list<mixed>|null,
 *   filteredCount?: int|null,
 *   readBackTo?: \DateTimeInterface|null,
 *   hiddenTimeline?: bool|null,
 *   windowComplete?: bool|null,
 *   searchedQuery?: string|null,
 *   searchContext?: SearchContext|array<string,mixed>|null,
 *   limitReached?: bool|null,
 *   orderPartial?: bool|null,
 *   hiddenReplies?: int|null,
 *   partialBefore?: \DateTimeInterface|null,
 *   unreachedReplies?: int|null,
 *   message?: string|null,
 * }
 */
final class TweetGetRepliesResponse implements BaseModel
{
    /** @use SdkModel<TweetGetRepliesResponseShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<mixed> $tweets */
    #[Required(list: SearchTweet::class)]
    public array $tweets;

    /**
     * Evidence for direct-reply coverage and collector behavior.
     */
    #[Optional]
    public ?Diagnostic $diagnostic;

    /**
     * Nested replies. Excluded from direct coverage.
     *
     * @var list<mixed>|null $nestedReplies
     */
    #[Optional('nested_replies', list: SearchTweet::class)]
    public ?array $nestedReplies;

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
     * Present when your limit cut a complete-mode answer. The post has more replies. Raise limit to get them all.
     */
    #[Optional('limit_reached')]
    public ?bool $limitReached;

    /**
     * Present with latest or oldest sort. The read stopped before it held every reply X shows. Rows stay sorted by date, but replies may be missing between them. Retry later for a gap-free order. Complete mode and automatic pages set it alike.
     */
    #[Optional]
    public ?bool $orderPartial;

    /**
     * Present on the last automatic page, and on a complete-mode answer without rows. X counts this many more replies but shows them to nobody. They may be hidden, protected or deleted. A retry returns the same replies.
     */
    #[Optional]
    public ?int $hiddenReplies;

    /**
     * Present on an answer that lacks some replies posted before this time. A retry returns about the same replies.
     */
    #[Optional]
    public ?\DateTimeInterface $partialBefore;

    /**
     * Present on automatic pages without filters while X counts replies the read hasn't reached. If a reply that belongs in your rows is missing, it's among them. The count drops as you read more pages. On the last page, it counts the replies the read can't reach.
     */
    #[Optional]
    public ?int $unreachedReplies;

    /**
     * Explains an answer cut by your limit.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new TweetGetRepliesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetGetRepliesResponse::with(hasNextPage: ..., nextCursor: ..., tweets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetGetRepliesResponse)
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
     * @param Diagnostic|DiagnosticShape|null $diagnostic
     * @param list<mixed>|null $nestedReplies
     * @param SearchContext|array<string,mixed>|null $searchContext
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $tweets,
        Diagnostic|array|null $diagnostic = null,
        ?array $nestedReplies = null,
        ?int $filteredCount = null,
        ?\DateTimeInterface $readBackTo = null,
        ?bool $hiddenTimeline = null,
        ?bool $windowComplete = null,
        ?string $searchedQuery = null,
        SearchContext|array|null $searchContext = null,
        ?bool $limitReached = null,
        ?bool $orderPartial = null,
        ?int $hiddenReplies = null,
        ?\DateTimeInterface $partialBefore = null,
        ?int $unreachedReplies = null,
        ?string $message = null
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['tweets'] = $tweets;

        null !== $diagnostic && $self['diagnostic'] = $diagnostic;
        null !== $nestedReplies && $self['nestedReplies'] = $nestedReplies;

        null !== $filteredCount && $self['filteredCount'] = $filteredCount;

        null !== $readBackTo && $self['readBackTo'] = $readBackTo;

        null !== $hiddenTimeline && $self['hiddenTimeline'] = $hiddenTimeline;

        null !== $windowComplete && $self['windowComplete'] = $windowComplete;

        null !== $searchedQuery && $self['searchedQuery'] = $searchedQuery;

        null !== $searchContext && $self['searchContext'] = $searchContext;

        null !== $limitReached && $self['limitReached'] = $limitReached;

        null !== $orderPartial && $self['orderPartial'] = $orderPartial;

        null !== $hiddenReplies && $self['hiddenReplies'] = $hiddenReplies;

        null !== $partialBefore && $self['partialBefore'] = $partialBefore;

        null !== $unreachedReplies && $self['unreachedReplies'] = $unreachedReplies;

        null !== $message && $self['message'] = $message;

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
     * Evidence for direct-reply coverage and collector behavior.
     *
     * @param Diagnostic|DiagnosticShape $diagnostic
     */
    public function withDiagnostic(Diagnostic|array $diagnostic): self
    {
        $self = clone $this;
        $self['diagnostic'] = $diagnostic;

        return $self;
    }

    /**
     * Nested replies. Excluded from direct coverage.
     *
     * @param list<mixed> $nestedReplies
     */
    public function withNestedReplies(array $nestedReplies): self
    {
        $self = clone $this;
        $self['nestedReplies'] = $nestedReplies;

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

    /**
     * Present when your limit cut a complete-mode answer. The post has more replies. Raise limit to get them all.
     */
    public function withLimitReached(?bool $limitReached): self
    {
        $self = clone $this;
        $self['limitReached'] = $limitReached;

        return $self;
    }

    /**
     * Present with latest or oldest sort. The read stopped before it held every reply X shows. Rows stay sorted by date, but replies may be missing between them. Retry later for a gap-free order. Complete mode and automatic pages set it alike.
     */
    public function withOrderPartial(?bool $orderPartial): self
    {
        $self = clone $this;
        $self['orderPartial'] = $orderPartial;

        return $self;
    }

    /**
     * Present on the last automatic page, and on a complete-mode answer without rows. X counts this many more replies but shows them to nobody. They may be hidden, protected or deleted. A retry returns the same replies.
     */
    public function withHiddenReplies(?int $hiddenReplies): self
    {
        $self = clone $this;
        $self['hiddenReplies'] = $hiddenReplies;

        return $self;
    }

    /**
     * Present on an answer that lacks some replies posted before this time. A retry returns about the same replies.
     */
    public function withPartialBefore(?\DateTimeInterface $partialBefore): self
    {
        $self = clone $this;
        $self['partialBefore'] = $partialBefore;

        return $self;
    }

    /**
     * Present on automatic pages without filters while X counts replies the read hasn't reached. If a reply that belongs in your rows is missing, it's among them. The count drops as you read more pages. On the last page, it counts the replies the read can't reach.
     */
    public function withUnreachedReplies(?int $unreachedReplies): self
    {
        $self = clone $this;
        $self['unreachedReplies'] = $unreachedReplies;

        return $self;
    }

    /**
     * Explains an answer cut by your limit.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
