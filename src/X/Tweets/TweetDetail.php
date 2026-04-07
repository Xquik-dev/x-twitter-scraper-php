<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetDetail\Media;

/**
 * @phpstan-import-type MediaShape from \XTwitterScraper\X\Tweets\TweetDetail\Media
 *
 * @phpstan-type TweetDetailShape = array{
 *   id: string,
 *   bookmarkCount: int,
 *   likeCount: int,
 *   quoteCount: int,
 *   replyCount: int,
 *   retweetCount: int,
 *   text: string,
 *   viewCount: int,
 *   conversationID?: string|null,
 *   createdAt?: string|null,
 *   entities?: mixed,
 *   isNoteTweet?: bool|null,
 *   isQuoteStatus?: bool|null,
 *   isReply?: bool|null,
 *   media?: list<Media|MediaShape>|null,
 *   quotedTweet?: mixed,
 *   source?: string|null,
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

    /**
     * ID of the root tweet in the conversation thread.
     */
    #[Optional('conversationId')]
    public ?string $conversationID;

    #[Optional]
    public ?string $createdAt;

    /**
     * Parsed entities from the tweet text (URLs, mentions, hashtags, media).
     */
    #[Optional]
    public mixed $entities;

    /**
     * Whether this is a Note Tweet (long-form post, up to 25,000 characters).
     */
    #[Optional]
    public ?bool $isNoteTweet;

    /**
     * Whether this tweet quotes another tweet.
     */
    #[Optional]
    public ?bool $isQuoteStatus;

    /**
     * Whether this tweet is a reply to another tweet.
     */
    #[Optional]
    public ?bool $isReply;

    /**
     * Attached media items, omitted when the tweet has no media.
     *
     * @var list<Media>|null $media
     */
    #[Optional(list: Media::class)]
    public ?array $media;

    /**
     * The quoted tweet object, present when isQuoteStatus is true.
     */
    #[Optional('quoted_tweet')]
    public mixed $quotedTweet;

    /**
     * Client application used to post this tweet.
     */
    #[Optional]
    public ?string $source;

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
     *
     * @param list<Media|MediaShape>|null $media
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
        ?string $conversationID = null,
        ?string $createdAt = null,
        mixed $entities = null,
        ?bool $isNoteTweet = null,
        ?bool $isQuoteStatus = null,
        ?bool $isReply = null,
        ?array $media = null,
        mixed $quotedTweet = null,
        ?string $source = null,
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

        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $entities && $self['entities'] = $entities;
        null !== $isNoteTweet && $self['isNoteTweet'] = $isNoteTweet;
        null !== $isQuoteStatus && $self['isQuoteStatus'] = $isQuoteStatus;
        null !== $isReply && $self['isReply'] = $isReply;
        null !== $media && $self['media'] = $media;
        null !== $quotedTweet && $self['quotedTweet'] = $quotedTweet;
        null !== $source && $self['source'] = $source;

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

    /**
     * ID of the root tweet in the conversation thread.
     */
    public function withConversationID(string $conversationID): self
    {
        $self = clone $this;
        $self['conversationID'] = $conversationID;

        return $self;
    }

    public function withCreatedAt(string $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Parsed entities from the tweet text (URLs, mentions, hashtags, media).
     */
    public function withEntities(mixed $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    /**
     * Whether this is a Note Tweet (long-form post, up to 25,000 characters).
     */
    public function withIsNoteTweet(bool $isNoteTweet): self
    {
        $self = clone $this;
        $self['isNoteTweet'] = $isNoteTweet;

        return $self;
    }

    /**
     * Whether this tweet quotes another tweet.
     */
    public function withIsQuoteStatus(bool $isQuoteStatus): self
    {
        $self = clone $this;
        $self['isQuoteStatus'] = $isQuoteStatus;

        return $self;
    }

    /**
     * Whether this tweet is a reply to another tweet.
     */
    public function withIsReply(bool $isReply): self
    {
        $self = clone $this;
        $self['isReply'] = $isReply;

        return $self;
    }

    /**
     * Attached media items, omitted when the tweet has no media.
     *
     * @param list<Media|MediaShape> $media
     */
    public function withMedia(array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * The quoted tweet object, present when isQuoteStatus is true.
     */
    public function withQuotedTweet(mixed $quotedTweet): self
    {
        $self = clone $this;
        $self['quotedTweet'] = $quotedTweet;

        return $self;
    }

    /**
     * Client application used to post this tweet.
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }
}
