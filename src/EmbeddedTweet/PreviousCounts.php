<?php

declare(strict_types=1);

namespace XTwitterScraper\EmbeddedTweet;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Engagement counts retained from a prior tweet edit.
 *
 * @phpstan-type PreviousCountsShape = array{
 *   bookmarkCount?: int|null,
 *   likeCount?: int|null,
 *   quoteCount?: int|null,
 *   replyCount?: int|null,
 *   retweetCount?: int|null,
 * }
 */
final class PreviousCounts implements BaseModel
{
    /** @use SdkModel<PreviousCountsShape> */
    use SdkModel;

    #[Optional]
    public ?int $bookmarkCount;

    #[Optional]
    public ?int $likeCount;

    #[Optional]
    public ?int $quoteCount;

    #[Optional]
    public ?int $replyCount;

    #[Optional]
    public ?int $retweetCount;

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
        ?int $bookmarkCount = null,
        ?int $likeCount = null,
        ?int $quoteCount = null,
        ?int $replyCount = null,
        ?int $retweetCount = null,
    ): self {
        $self = new self;

        null !== $bookmarkCount && $self['bookmarkCount'] = $bookmarkCount;
        null !== $likeCount && $self['likeCount'] = $likeCount;
        null !== $quoteCount && $self['quoteCount'] = $quoteCount;
        null !== $replyCount && $self['replyCount'] = $replyCount;
        null !== $retweetCount && $self['retweetCount'] = $retweetCount;

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
}
