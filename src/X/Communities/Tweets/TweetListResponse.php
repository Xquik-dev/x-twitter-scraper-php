<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\Tweets\TweetListResponse\Tweet;

/**
 * Paginated list of tweets with cursor-based navigation.
 *
 * @phpstan-import-type TweetShape from \XTwitterScraper\X\Communities\Tweets\TweetListResponse\Tweet
 *
 * @phpstan-type TweetListResponseShape = array{
 *   hasNextPage: bool, nextCursor: string, tweets: list<Tweet|TweetShape>
 * }
 */
final class TweetListResponse implements BaseModel
{
    /** @use SdkModel<TweetListResponseShape> */
    use SdkModel;

    #[Required('has_next_page')]
    public bool $hasNextPage;

    #[Required('next_cursor')]
    public string $nextCursor;

    /** @var list<Tweet> $tweets */
    #[Required(list: Tweet::class)]
    public array $tweets;

    /**
     * `new TweetListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetListResponse::with(hasNextPage: ..., nextCursor: ..., tweets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetListResponse)
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
     * @param list<Tweet|TweetShape> $tweets
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
     * @param list<Tweet|TweetShape> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }
}
