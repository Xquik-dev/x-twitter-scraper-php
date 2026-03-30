<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetDetailShape = array{
 *   id: string,
 *   bookmarkCount: int,
 *   likeCount: int,
 *   quoteCount: int,
 *   replyCount: int,
 *   retweetCount: int,
 *   text: string,
 *   viewCount: int,
 *   createdAt?: string|null,
 * }
 */
final class TweetDetail implements BaseModel
{
    /** @use SdkModel<TweetDetailShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public int $bookmarkCount;

    #[Required]
    public int $likeCount;

    #[Required]
    public int $quoteCount;

    #[Required]
    public int $replyCount;

    #[Required]
    public int $retweetCount;

    #[Required]
    public string $text;

    #[Required]
    public int $viewCount;

    #[Optional]
    public ?string $createdAt;

    /**
     * `new TweetDetail()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetDetail::with(
     *   id: ...,
     *   bookmarkCount: ...,
     *   likeCount: ...,
     *   quoteCount: ...,
     *   replyCount: ...,
     *   retweetCount: ...,
     *   text: ...,
     *   viewCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetDetail)
     *   ->withID(...)
     *   ->withBookmarkCount(...)
     *   ->withLikeCount(...)
     *   ->withQuoteCount(...)
     *   ->withReplyCount(...)
     *   ->withRetweetCount(...)
     *   ->withText(...)
     *   ->withViewCount(...)
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
     */
    public static function with(
        string $id,
        int $bookmarkCount,
        int $likeCount,
        int $quoteCount,
        int $replyCount,
        int $retweetCount,
        string $text,
        int $viewCount,
        ?string $createdAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['bookmarkCount'] = $bookmarkCount;
        $self['likeCount'] = $likeCount;
        $self['quoteCount'] = $quoteCount;
        $self['replyCount'] = $replyCount;
        $self['retweetCount'] = $retweetCount;
        $self['text'] = $text;
        $self['viewCount'] = $viewCount;

        null !== $createdAt && $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withBookmarkCount(int $bookmarkCount): self
    {
        $self = clone $this;
        $self['bookmarkCount'] = $bookmarkCount;

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

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    public function withViewCount(int $viewCount): self
    {
        $self = clone $this;
        $self['viewCount'] = $viewCount;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }
}
