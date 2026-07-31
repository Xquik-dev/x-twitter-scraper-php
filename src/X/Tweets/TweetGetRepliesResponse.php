<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\SearchTweet;
use XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic;

/**
 * Reply rows. Complete mode also returns nested replies and coverage diagnostics. Keep nested replies separate from direct coverage.
 *
 * @phpstan-import-type DiagnosticShape from \XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic
 *
 * @phpstan-type TweetGetRepliesResponseShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   tweets: list<mixed>,
 *   diagnostic?: null|Diagnostic|DiagnosticShape,
 *   nestedReplies?: list<mixed>|null,
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
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $tweets,
        Diagnostic|array|null $diagnostic = null,
        ?array $nestedReplies = null,
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['tweets'] = $tweets;

        null !== $diagnostic && $self['diagnostic'] = $diagnostic;
        null !== $nestedReplies && $self['nestedReplies'] = $nestedReplies;

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
}
