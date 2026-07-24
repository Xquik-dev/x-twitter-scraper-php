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

/**
 * Quoted or retweeted tweet context. Every object includes id, text, and engagement metrics. A zero metric can mean X did not report the count. Author, media, and conversation fields appear when available.
 *
 * @phpstan-import-type UserProfileShape from \XTwitterScraper\UserProfile
 * @phpstan-import-type ContentDisclosureShape from \XTwitterScraper\ContentDisclosure
 * @phpstan-import-type TweetMediaShape from \XTwitterScraper\TweetMedia
 *
 * @phpstan-type EmbeddedTweetShape = array{
 *   id: string,
 *   bookmarkCount: int,
 *   likeCount: int,
 *   quoteCount: int,
 *   replyCount: int,
 *   retweetCount: int,
 *   text: string,
 *   viewCount: int,
 *   author?: null|UserProfile|UserProfileShape,
 *   contentDisclosure?: null|ContentDisclosure|ContentDisclosureShape,
 *   conversationID?: string|null,
 *   createdAt?: string|null,
 *   displayTextRange?: list<int>|null,
 *   entities?: array<string,mixed>|null,
 *   inReplyToID?: string|null,
 *   inReplyToUserID?: string|null,
 *   inReplyToUsername?: string|null,
 *   isLimitedReply?: bool|null,
 *   isNoteTweet?: bool|null,
 *   isQuoteStatus?: bool|null,
 *   isReply?: bool|null,
 *   lang?: string|null,
 *   media?: list<TweetMedia|TweetMediaShape>|null,
 *   source?: string|null,
 *   type?: string|null,
 *   url?: string|null,
 * }
 */
final class EmbeddedTweet implements BaseModel
{
    /** @use SdkModel<EmbeddedTweetShape> */
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
     * X user profile with bio, follower counts, and verification status.
     */
    #[Optional]
    public ?UserProfile $author;

    /**
     * Content disclosure metadata shown by X when a tweet is labeled as paid partnership content or AI-generated media.
     */
    #[Optional]
    public ?ContentDisclosure $contentDisclosure;

    #[Optional('conversationId')]
    public ?string $conversationID;

    #[Optional]
    public ?string $createdAt;

    /** @var list<int>|null $displayTextRange */
    #[Optional(list: 'int')]
    public ?array $displayTextRange;

    /** @var array<string,mixed>|null $entities */
    #[Optional(map: 'mixed')]
    public ?array $entities;

    #[Optional('inReplyToId')]
    public ?string $inReplyToID;

    #[Optional('inReplyToUserId')]
    public ?string $inReplyToUserID;

    #[Optional]
    public ?string $inReplyToUsername;

    #[Optional]
    public ?bool $isLimitedReply;

    #[Optional]
    public ?bool $isNoteTweet;

    #[Optional]
    public ?bool $isQuoteStatus;

    #[Optional]
    public ?bool $isReply;

    #[Optional]
    public ?string $lang;

    /** @var list<TweetMedia>|null $media */
    #[Optional(list: TweetMedia::class)]
    public ?array $media;

    #[Optional]
    public ?string $source;

    #[Optional]
    public ?string $type;

    #[Optional]
    public ?string $url;

    /**
     * `new EmbeddedTweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * EmbeddedTweet::with(
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
     * (new EmbeddedTweet)
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
     * @param UserProfile|UserProfileShape|null $author
     * @param ContentDisclosure|ContentDisclosureShape|null $contentDisclosure
     * @param list<int>|null $displayTextRange
     * @param array<string,mixed>|null $entities
     * @param list<TweetMedia|TweetMediaShape>|null $media
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
        UserProfile|array|null $author = null,
        ContentDisclosure|array|null $contentDisclosure = null,
        ?string $conversationID = null,
        ?string $createdAt = null,
        ?array $displayTextRange = null,
        ?array $entities = null,
        ?string $inReplyToID = null,
        ?string $inReplyToUserID = null,
        ?string $inReplyToUsername = null,
        ?bool $isLimitedReply = null,
        ?bool $isNoteTweet = null,
        ?bool $isQuoteStatus = null,
        ?bool $isReply = null,
        ?string $lang = null,
        ?array $media = null,
        ?string $source = null,
        ?string $type = null,
        ?string $url = null,
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

        null !== $author && $self['author'] = $author;
        null !== $contentDisclosure && $self['contentDisclosure'] = $contentDisclosure;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $displayTextRange && $self['displayTextRange'] = $displayTextRange;
        null !== $entities && $self['entities'] = $entities;
        null !== $inReplyToID && $self['inReplyToID'] = $inReplyToID;
        null !== $inReplyToUserID && $self['inReplyToUserID'] = $inReplyToUserID;
        null !== $inReplyToUsername && $self['inReplyToUsername'] = $inReplyToUsername;
        null !== $isLimitedReply && $self['isLimitedReply'] = $isLimitedReply;
        null !== $isNoteTweet && $self['isNoteTweet'] = $isNoteTweet;
        null !== $isQuoteStatus && $self['isQuoteStatus'] = $isQuoteStatus;
        null !== $isReply && $self['isReply'] = $isReply;
        null !== $lang && $self['lang'] = $lang;
        null !== $media && $self['media'] = $media;
        null !== $source && $self['source'] = $source;
        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;

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
     * X user profile with bio, follower counts, and verification status.
     *
     * @param UserProfile|UserProfileShape $author
     */
    public function withAuthor(UserProfile|array $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }

    /**
     * Content disclosure metadata shown by X when a tweet is labeled as paid partnership content or AI-generated media.
     *
     * @param ContentDisclosure|ContentDisclosureShape $contentDisclosure
     */
    public function withContentDisclosure(
        ContentDisclosure|array $contentDisclosure
    ): self {
        $self = clone $this;
        $self['contentDisclosure'] = $contentDisclosure;

        return $self;
    }

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
     * @param list<int> $displayTextRange
     */
    public function withDisplayTextRange(array $displayTextRange): self
    {
        $self = clone $this;
        $self['displayTextRange'] = $displayTextRange;

        return $self;
    }

    /**
     * @param array<string,mixed> $entities
     */
    public function withEntities(array $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    public function withInReplyToID(string $inReplyToID): self
    {
        $self = clone $this;
        $self['inReplyToID'] = $inReplyToID;

        return $self;
    }

    public function withInReplyToUserID(string $inReplyToUserID): self
    {
        $self = clone $this;
        $self['inReplyToUserID'] = $inReplyToUserID;

        return $self;
    }

    public function withInReplyToUsername(string $inReplyToUsername): self
    {
        $self = clone $this;
        $self['inReplyToUsername'] = $inReplyToUsername;

        return $self;
    }

    public function withIsLimitedReply(bool $isLimitedReply): self
    {
        $self = clone $this;
        $self['isLimitedReply'] = $isLimitedReply;

        return $self;
    }

    public function withIsNoteTweet(bool $isNoteTweet): self
    {
        $self = clone $this;
        $self['isNoteTweet'] = $isNoteTweet;

        return $self;
    }

    public function withIsQuoteStatus(bool $isQuoteStatus): self
    {
        $self = clone $this;
        $self['isQuoteStatus'] = $isQuoteStatus;

        return $self;
    }

    public function withIsReply(bool $isReply): self
    {
        $self = clone $this;
        $self['isReply'] = $isReply;

        return $self;
    }

    public function withLang(string $lang): self
    {
        $self = clone $this;
        $self['lang'] = $lang;

        return $self;
    }

    /**
     * @param list<TweetMedia|TweetMediaShape> $media
     */
    public function withMedia(array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
