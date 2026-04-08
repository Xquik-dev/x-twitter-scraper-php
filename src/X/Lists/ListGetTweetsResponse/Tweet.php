<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Lists\ListGetTweetsResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Lists\ListGetTweetsResponse\Tweet\Author;

/**
 * Tweet returned from search results with inline author info.
 *
 * @phpstan-import-type AuthorShape from \XTwitterScraper\X\Lists\ListGetTweetsResponse\Tweet\Author
 *
 * @phpstan-type TweetShape = array{
 *   id: string,
 *   text: string,
 *   author?: null|Author|AuthorShape,
 *   bookmarkCount?: int|null,
 *   createdAt?: string|null,
 *   isNoteTweet?: bool|null,
 *   likeCount?: int|null,
 *   quoteCount?: int|null,
 *   replyCount?: int|null,
 *   retweetCount?: int|null,
 *   viewCount?: int|null,
 * }
 */
final class Tweet implements BaseModel
{
    /** @use SdkModel<TweetShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $text;

    #[Optional]
    public ?Author $author;

    #[Optional]
    public ?int $bookmarkCount;

    #[Optional]
    public ?string $createdAt;

    /**
     * True for Note Tweets (long-form content, up to 25,000 characters).
     */
    #[Optional]
    public ?bool $isNoteTweet;

    #[Optional]
    public ?int $likeCount;

    #[Optional]
    public ?int $quoteCount;

    #[Optional]
    public ?int $replyCount;

    #[Optional]
    public ?int $retweetCount;

    #[Optional]
    public ?int $viewCount;

    /**
     * `new Tweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Tweet::with(id: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Tweet)->withID(...)->withText(...)
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
     * @param Author|AuthorShape|null $author
     */
    public static function with(
        string $id,
        string $text,
        Author|array|null $author = null,
        ?int $bookmarkCount = null,
        ?string $createdAt = null,
        ?bool $isNoteTweet = null,
        ?int $likeCount = null,
        ?int $quoteCount = null,
        ?int $replyCount = null,
        ?int $retweetCount = null,
        ?int $viewCount = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['text'] = $text;

        null !== $author && $self['author'] = $author;
        null !== $bookmarkCount && $self['bookmarkCount'] = $bookmarkCount;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $isNoteTweet && $self['isNoteTweet'] = $isNoteTweet;
        null !== $likeCount && $self['likeCount'] = $likeCount;
        null !== $quoteCount && $self['quoteCount'] = $quoteCount;
        null !== $replyCount && $self['replyCount'] = $replyCount;
        null !== $retweetCount && $self['retweetCount'] = $retweetCount;
        null !== $viewCount && $self['viewCount'] = $viewCount;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * @param Author|AuthorShape $author
     */
    public function withAuthor(Author|array $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }

    public function withBookmarkCount(int $bookmarkCount): self
    {
        $self = clone $this;
        $self['bookmarkCount'] = $bookmarkCount;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * True for Note Tweets (long-form content, up to 25,000 characters).
     */
    public function withIsNoteTweet(bool $isNoteTweet): self
    {
        $self = clone $this;
        $self['isNoteTweet'] = $isNoteTweet;

        return $self;
    }

    public function withLikeCount(int $likeCount): self
    {
        $self = clone $this;
        $self['likeCount'] = $likeCount;

        return $self;
    }

    public function withQuoteCount(int $quoteCount): self
    {
        $self = clone $this;
        $self['quoteCount'] = $quoteCount;

        return $self;
    }

    public function withReplyCount(int $replyCount): self
    {
        $self = clone $this;
        $self['replyCount'] = $replyCount;

        return $self;
    }

    public function withRetweetCount(int $retweetCount): self
    {
        $self = clone $this;
        $self['retweetCount'] = $retweetCount;

        return $self;
    }

    public function withViewCount(int $viewCount): self
    {
        $self = clone $this;
        $self['viewCount'] = $viewCount;

        return $self;
    }
}
