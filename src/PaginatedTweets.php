<?php

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Paginated tweet results. The item count can be lower than pageSize when the source returns fewer tweets, filters remove tweets, or remaining credits cover fewer results. Follow next_cursor while has_next_page is true. An empty page can still have has_next_page true after filtering. Zero affordable results returns 402 insufficient_credits.
 *
 * @phpstan-import-type SearchTweetShape from \XTwitterScraper\SearchTweet
 *
 * @phpstan-type PaginatedTweetsShape = array{
 *   hasNextPage: bool,
 *   nextCursor: string,
 *   tweets: list<SearchTweet|SearchTweetShape>,
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

    /** @var list<SearchTweet> $tweets */
    #[Required(list: SearchTweet::class)]
    public array $tweets;

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
     * @param list<SearchTweet|SearchTweetShape> $tweets
     */
    public static function with(
        bool $hasNextPage,
        string $nextCursor,
        array $tweets
    ): self {
        $self = new self;

        $self['hasNextPage'] = $hasNextPage;
        $self['nextCursor'] = $nextCursor;
        $self['tweets'] = $tweets;

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
     * @param list<SearchTweet|SearchTweetShape> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }
}
