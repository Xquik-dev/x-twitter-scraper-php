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
use XTwitterScraper\SearchTweet\Article;
use XTwitterScraper\SearchTweet\Card;
use XTwitterScraper\SearchTweet\CommunityNote;
use XTwitterScraper\SearchTweet\Edit;
use XTwitterScraper\SearchTweet\NoteTweet;
use XTwitterScraper\SearchTweet\Place;
use XTwitterScraper\SearchTweet\PreviousCounts;

/**
 * Tweet returned from search results with inline author info. A zero metric can mean X did not report the count.
 *
 * @phpstan-import-type ArticleShape from \XTwitterScraper\SearchTweet\Article
 * @phpstan-import-type UserProfileShape from \XTwitterScraper\UserProfile
 * @phpstan-import-type CardShape from \XTwitterScraper\SearchTweet\Card
 * @phpstan-import-type CommunityNoteShape from \XTwitterScraper\SearchTweet\CommunityNote
 * @phpstan-import-type ContentDisclosureShape from \XTwitterScraper\ContentDisclosure
 * @phpstan-import-type EditShape from \XTwitterScraper\SearchTweet\Edit
 * @phpstan-import-type TweetMediaShape from \XTwitterScraper\TweetMedia
 * @phpstan-import-type NoteTweetShape from \XTwitterScraper\SearchTweet\NoteTweet
 * @phpstan-import-type PlaceShape from \XTwitterScraper\SearchTweet\Place
 * @phpstan-import-type PreviousCountsShape from \XTwitterScraper\SearchTweet\PreviousCounts
 * @phpstan-import-type EmbeddedTweetShape from \XTwitterScraper\EmbeddedTweet
 *
 * @phpstan-type SearchTweetShape = array{
 *   id: string,
 *   bookmarkCount: int,
 *   likeCount: int,
 *   quoteCount: int,
 *   replyCount: int,
 *   retweetCount: int,
 *   text: string,
 *   viewCount: int,
 *   article?: null|Article|ArticleShape,
 *   author?: null|UserProfile|UserProfileShape,
 *   card?: null|Card|CardShape,
 *   communityNote?: null|CommunityNote|CommunityNoteShape,
 *   contentDisclosure?: null|ContentDisclosure|ContentDisclosureShape,
 *   conversationID?: string|null,
 *   createdAt?: string|null,
 *   displayTextRange?: list<int>|null,
 *   edit?: null|Edit|EditShape,
 *   entities?: array<string,mixed>|null,
 *   inReplyToID?: string|null,
 *   inReplyToUserID?: string|null,
 *   inReplyToUsername?: string|null,
 *   isLimitedReply?: bool|null,
 *   isNoteTweet?: bool|null,
 *   isQuoteStatus?: bool|null,
 *   isReply?: bool|null,
 *   isTranslatable?: bool|null,
 *   lang?: string|null,
 *   media?: list<TweetMedia|TweetMediaShape>|null,
 *   noteTweet?: null|NoteTweet|NoteTweetShape,
 *   place?: null|Place|PlaceShape,
 *   possiblySensitive?: bool|null,
 *   previousCounts?: null|PreviousCounts|PreviousCountsShape,
 *   quotedTweet?: null|EmbeddedTweet|EmbeddedTweetShape,
 *   retweetedTweet?: null|EmbeddedTweet|EmbeddedTweetShape,
 *   source?: string|null,
 *   type?: string|null,
 *   url?: string|null,
 *   viewState?: string|null,
 * }
 */
final class SearchTweet implements BaseModel
{
    /** @use SdkModel<SearchTweetShape> */
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
     * Article metadata attached to a tweet.
     */
    #[Optional]
    public ?Article $article;

    /**
     * X user profile with bio, follower counts, and verification status.
     */
    #[Optional]
    public ?UserProfile $author;

    /**
     * Public card metadata attached to a tweet.
     */
    #[Optional]
    public ?Card $card;

    /**
     * Community Note presentation metadata returned by X.
     */
    #[Optional]
    public ?CommunityNote $communityNote;

    /**
     * Content disclosure metadata shown by X when a tweet is labeled as paid partnership content or AI-generated media.
     */
    #[Optional]
    public ?ContentDisclosure $contentDisclosure;

    /**
     * Root tweet ID for the search result conversation.
     */
    #[Optional('conversationId')]
    public ?string $conversationID;

    #[Optional]
    public ?string $createdAt;

    /**
     * Rendered text's start and end offsets.
     *
     * @var list<int>|null $displayTextRange
     */
    #[Optional(list: 'int')]
    public ?array $displayTextRange;

    /**
     * Edit history metadata returned by X.
     */
    #[Optional]
    public ?Edit $edit;

    /**
     * Parsed search-result entities including URLs, mentions, hashtags, and media markers.
     *
     * @var array<string,mixed>|null $entities
     */
    #[Optional(map: 'mixed')]
    public ?array $entities;

    /**
     * ID of the tweet this result replies to.
     */
    #[Optional('inReplyToId')]
    public ?string $inReplyToID;

    /**
     * ID of the user this result replies to.
     */
    #[Optional('inReplyToUserId')]
    public ?string $inReplyToUserID;

    /**
     * Username this result replies to.
     */
    #[Optional]
    public ?string $inReplyToUsername;

    /**
     * Whether the tweet has limited reply permissions.
     */
    #[Optional]
    public ?bool $isLimitedReply;

    /**
     * True for Note Tweets (long-form content, up to 25,000 characters).
     */
    #[Optional]
    public ?bool $isNoteTweet;

    /**
     * True when this search result quotes another tweet.
     */
    #[Optional]
    public ?bool $isQuoteStatus;

    /**
     * True when this search result is a reply.
     */
    #[Optional]
    public ?bool $isReply;

    #[Optional]
    public ?bool $isTranslatable;

    /**
     * Search result language code.
     */
    #[Optional]
    public ?string $lang;

    /**
     * Search-result media attachments, omitted when no media is present.
     *
     * @var list<TweetMedia>|null $media
     */
    #[Optional(list: TweetMedia::class)]
    public ?array $media;

    /**
     * Complete Note Tweet content and rich-text metadata.
     */
    #[Optional]
    public ?NoteTweet $noteTweet;

    /**
     * Public place metadata attached to a tweet.
     */
    #[Optional]
    public ?Place $place;

    #[Optional]
    public ?bool $possiblySensitive;

    /**
     * Engagement counts retained from a prior tweet edit.
     */
    #[Optional]
    public ?PreviousCounts $previousCounts;

    /**
     * Quoted or retweeted tweet context. Every object includes id, text, and engagement metrics. A zero metric can mean X did not report the count. Author, media, and conversation fields appear when available.
     */
    #[Optional('quoted_tweet')]
    public ?EmbeddedTweet $quotedTweet;

    /**
     * Quoted or retweeted tweet context. Every object includes id, text, and engagement metrics. A zero metric can mean X did not report the count. Author, media, and conversation fields appear when available.
     */
    #[Optional('retweeted_tweet')]
    public ?EmbeddedTweet $retweetedTweet;

    /**
     * Client application used to post the tweet.
     */
    #[Optional]
    public ?string $source;

    #[Optional]
    public ?string $type;

    /**
     * Search result permalink.
     */
    #[Optional]
    public ?string $url;

    #[Optional]
    public ?string $viewState;

    /**
     * `new SearchTweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchTweet::with(
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
     * (new SearchTweet)
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
     * @param Article|ArticleShape|null $article
     * @param UserProfile|UserProfileShape|null $author
     * @param Card|CardShape|null $card
     * @param CommunityNote|CommunityNoteShape|null $communityNote
     * @param ContentDisclosure|ContentDisclosureShape|null $contentDisclosure
     * @param list<int>|null $displayTextRange
     * @param Edit|EditShape|null $edit
     * @param array<string,mixed>|null $entities
     * @param list<TweetMedia|TweetMediaShape>|null $media
     * @param NoteTweet|NoteTweetShape|null $noteTweet
     * @param Place|PlaceShape|null $place
     * @param PreviousCounts|PreviousCountsShape|null $previousCounts
     * @param EmbeddedTweet|EmbeddedTweetShape|null $quotedTweet
     * @param EmbeddedTweet|EmbeddedTweetShape|null $retweetedTweet
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
        Article|array|null $article = null,
        UserProfile|array|null $author = null,
        Card|array|null $card = null,
        CommunityNote|array|null $communityNote = null,
        ContentDisclosure|array|null $contentDisclosure = null,
        ?string $conversationID = null,
        ?string $createdAt = null,
        ?array $displayTextRange = null,
        Edit|array|null $edit = null,
        ?array $entities = null,
        ?string $inReplyToID = null,
        ?string $inReplyToUserID = null,
        ?string $inReplyToUsername = null,
        ?bool $isLimitedReply = null,
        ?bool $isNoteTweet = null,
        ?bool $isQuoteStatus = null,
        ?bool $isReply = null,
        ?bool $isTranslatable = null,
        ?string $lang = null,
        ?array $media = null,
        NoteTweet|array|null $noteTweet = null,
        Place|array|null $place = null,
        ?bool $possiblySensitive = null,
        PreviousCounts|array|null $previousCounts = null,
        EmbeddedTweet|array|null $quotedTweet = null,
        EmbeddedTweet|array|null $retweetedTweet = null,
        ?string $source = null,
        ?string $type = null,
        ?string $url = null,
        ?string $viewState = null,
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

        null !== $article && $self['article'] = $article;
        null !== $author && $self['author'] = $author;
        null !== $card && $self['card'] = $card;
        null !== $communityNote && $self['communityNote'] = $communityNote;
        null !== $contentDisclosure && $self['contentDisclosure'] = $contentDisclosure;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $displayTextRange && $self['displayTextRange'] = $displayTextRange;
        null !== $edit && $self['edit'] = $edit;
        null !== $entities && $self['entities'] = $entities;
        null !== $inReplyToID && $self['inReplyToID'] = $inReplyToID;
        null !== $inReplyToUserID && $self['inReplyToUserID'] = $inReplyToUserID;
        null !== $inReplyToUsername && $self['inReplyToUsername'] = $inReplyToUsername;
        null !== $isLimitedReply && $self['isLimitedReply'] = $isLimitedReply;
        null !== $isNoteTweet && $self['isNoteTweet'] = $isNoteTweet;
        null !== $isQuoteStatus && $self['isQuoteStatus'] = $isQuoteStatus;
        null !== $isReply && $self['isReply'] = $isReply;
        null !== $isTranslatable && $self['isTranslatable'] = $isTranslatable;
        null !== $lang && $self['lang'] = $lang;
        null !== $media && $self['media'] = $media;
        null !== $noteTweet && $self['noteTweet'] = $noteTweet;
        null !== $place && $self['place'] = $place;
        null !== $possiblySensitive && $self['possiblySensitive'] = $possiblySensitive;
        null !== $previousCounts && $self['previousCounts'] = $previousCounts;
        null !== $quotedTweet && $self['quotedTweet'] = $quotedTweet;
        null !== $retweetedTweet && $self['retweetedTweet'] = $retweetedTweet;
        null !== $source && $self['source'] = $source;
        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;
        null !== $viewState && $self['viewState'] = $viewState;

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
     * Article metadata attached to a tweet.
     *
     * @param Article|ArticleShape $article
     */
    public function withArticle(Article|array $article): self
    {
        $self = clone $this;
        $self['article'] = $article;

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
     * Public card metadata attached to a tweet.
     *
     * @param Card|CardShape $card
     */
    public function withCard(Card|array $card): self
    {
        $self = clone $this;
        $self['card'] = $card;

        return $self;
    }

    /**
     * Community Note presentation metadata returned by X.
     *
     * @param CommunityNote|CommunityNoteShape $communityNote
     */
    public function withCommunityNote(CommunityNote|array $communityNote): self
    {
        $self = clone $this;
        $self['communityNote'] = $communityNote;

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

    /**
     * Root tweet ID for the search result conversation.
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
     * Rendered text's start and end offsets.
     *
     * @param list<int> $displayTextRange
     */
    public function withDisplayTextRange(array $displayTextRange): self
    {
        $self = clone $this;
        $self['displayTextRange'] = $displayTextRange;

        return $self;
    }

    /**
     * Edit history metadata returned by X.
     *
     * @param Edit|EditShape $edit
     */
    public function withEdit(Edit|array $edit): self
    {
        $self = clone $this;
        $self['edit'] = $edit;

        return $self;
    }

    /**
     * Parsed search-result entities including URLs, mentions, hashtags, and media markers.
     *
     * @param array<string,mixed> $entities
     */
    public function withEntities(array $entities): self
    {
        $self = clone $this;
        $self['entities'] = $entities;

        return $self;
    }

    /**
     * ID of the tweet this result replies to.
     */
    public function withInReplyToID(string $inReplyToID): self
    {
        $self = clone $this;
        $self['inReplyToID'] = $inReplyToID;

        return $self;
    }

    /**
     * ID of the user this result replies to.
     */
    public function withInReplyToUserID(string $inReplyToUserID): self
    {
        $self = clone $this;
        $self['inReplyToUserID'] = $inReplyToUserID;

        return $self;
    }

    /**
     * Username this result replies to.
     */
    public function withInReplyToUsername(string $inReplyToUsername): self
    {
        $self = clone $this;
        $self['inReplyToUsername'] = $inReplyToUsername;

        return $self;
    }

    /**
     * Whether the tweet has limited reply permissions.
     */
    public function withIsLimitedReply(bool $isLimitedReply): self
    {
        $self = clone $this;
        $self['isLimitedReply'] = $isLimitedReply;

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

    /**
     * True when this search result quotes another tweet.
     */
    public function withIsQuoteStatus(bool $isQuoteStatus): self
    {
        $self = clone $this;
        $self['isQuoteStatus'] = $isQuoteStatus;

        return $self;
    }

    /**
     * True when this search result is a reply.
     */
    public function withIsReply(bool $isReply): self
    {
        $self = clone $this;
        $self['isReply'] = $isReply;

        return $self;
    }

    public function withIsTranslatable(bool $isTranslatable): self
    {
        $self = clone $this;
        $self['isTranslatable'] = $isTranslatable;

        return $self;
    }

    /**
     * Search result language code.
     */
    public function withLang(string $lang): self
    {
        $self = clone $this;
        $self['lang'] = $lang;

        return $self;
    }

    /**
     * Search-result media attachments, omitted when no media is present.
     *
     * @param list<TweetMedia|TweetMediaShape> $media
     */
    public function withMedia(array $media): self
    {
        $self = clone $this;
        $self['media'] = $media;

        return $self;
    }

    /**
     * Complete Note Tweet content and rich-text metadata.
     *
     * @param NoteTweet|NoteTweetShape $noteTweet
     */
    public function withNoteTweet(NoteTweet|array $noteTweet): self
    {
        $self = clone $this;
        $self['noteTweet'] = $noteTweet;

        return $self;
    }

    /**
     * Public place metadata attached to a tweet.
     *
     * @param Place|PlaceShape $place
     */
    public function withPlace(Place|array $place): self
    {
        $self = clone $this;
        $self['place'] = $place;

        return $self;
    }

    public function withPossiblySensitive(bool $possiblySensitive): self
    {
        $self = clone $this;
        $self['possiblySensitive'] = $possiblySensitive;

        return $self;
    }

    /**
     * Engagement counts retained from a prior tweet edit.
     *
     * @param PreviousCounts|PreviousCountsShape $previousCounts
     */
    public function withPreviousCounts(
        PreviousCounts|array $previousCounts
    ): self {
        $self = clone $this;
        $self['previousCounts'] = $previousCounts;

        return $self;
    }

    /**
     * Quoted or retweeted tweet context. Every object includes id, text, and engagement metrics. A zero metric can mean X did not report the count. Author, media, and conversation fields appear when available.
     *
     * @param EmbeddedTweet|EmbeddedTweetShape $quotedTweet
     */
    public function withQuotedTweet(EmbeddedTweet|array $quotedTweet): self
    {
        $self = clone $this;
        $self['quotedTweet'] = $quotedTweet;

        return $self;
    }

    /**
     * Quoted or retweeted tweet context. Every object includes id, text, and engagement metrics. A zero metric can mean X did not report the count. Author, media, and conversation fields appear when available.
     *
     * @param EmbeddedTweet|EmbeddedTweetShape $retweetedTweet
     */
    public function withRetweetedTweet(
        EmbeddedTweet|array $retweetedTweet
    ): self {
        $self = clone $this;
        $self['retweetedTweet'] = $retweetedTweet;

        return $self;
    }

    /**
     * Client application used to post the tweet.
     */
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

    /**
     * Search result permalink.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withViewState(string $viewState): self
    {
        $self = clone $this;
        $self['viewState'] = $viewState;

        return $self;
    }
}
