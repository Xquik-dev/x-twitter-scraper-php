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
use XTwitterScraper\EmbeddedTweet\Article;
use XTwitterScraper\EmbeddedTweet\Card;
use XTwitterScraper\EmbeddedTweet\CashtagAttachments;
use XTwitterScraper\EmbeddedTweet\CommunityNote;
use XTwitterScraper\EmbeddedTweet\ConversationControl;
use XTwitterScraper\EmbeddedTweet\Edit;
use XTwitterScraper\EmbeddedTweet\LimitedActions;
use XTwitterScraper\EmbeddedTweet\LiveEventContext;
use XTwitterScraper\EmbeddedTweet\NoteTweet;
use XTwitterScraper\EmbeddedTweet\Place;
use XTwitterScraper\EmbeddedTweet\PreviousCounts;
use XTwitterScraper\EmbeddedTweet\QuotedTweetPermalink;
use XTwitterScraper\EmbeddedTweet\QuotedTweetUnavailable;
use XTwitterScraper\EmbeddedTweet\ReactionContext;
use XTwitterScraper\EmbeddedTweet\SoftIntervention;
use XTwitterScraper\EmbeddedTweet\SportsContext;
use XTwitterScraper\EmbeddedTweet\TextHighlights;
use XTwitterScraper\EmbeddedTweet\UnknownCounts;
use XTwitterScraper\EmbeddedTweet\UnknownFields;

/**
 * Quoted or retweeted tweet context. Every object includes id, text, and engagement metrics. A zero metric can mean X did not report the count. Author, media, and conversation fields appear when available.
 *
 * @phpstan-import-type ArticleShape from Article
 * @phpstan-import-type UserProfileShape from UserProfile
 * @phpstan-import-type CardShape from Card
 * @phpstan-import-type CommunityNoteShape from CommunityNote
 * @phpstan-import-type ContentDisclosureShape from ContentDisclosure
 * @phpstan-import-type EditShape from Edit
 * @phpstan-import-type TweetMediaShape from TweetMedia
 * @phpstan-import-type NoteTweetShape from NoteTweet
 * @phpstan-import-type PlaceShape from Place
 * @phpstan-import-type PreviousCountsShape from PreviousCounts
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
 *   quotedTweet?: EmbeddedTweet|null,
 *   retweetedTweet?: EmbeddedTweet|null,
 *   source?: string|null,
 *   type?: string|null,
 *   url?: string|null,
 *   viewState?: string|null,
 *   isPinned?: bool|null,
 *   isRetweet?: bool|null,
 *   quotedTweetID?: string|null,
 *   quotedTweetPermalink?: QuotedTweetPermalink|array<string,mixed>|null,
 *   quotedTweetUnavailable?: QuotedTweetUnavailable|array<string,mixed>|null,
 *   retweetedAt?: \DateTimeInterface|null,
 *   conversationControl?: ConversationControl|array<string,mixed>|null,
 *   limitedActions?: list<LimitedActions|array<string,mixed>>|null,
 *   textHighlights?: list<TextHighlights|array<string,mixed>>|null,
 *   authorUnavailable?: TweetAuthorUnavailable|array<string,mixed>|null,
 *   unavailableAuthorID?: string|null,
 *   cashtagAttachments?: list<CashtagAttachments|array<string,mixed>>|null,
 *   communityID?: string|null,
 *   communityName?: string|null,
 *   hasCommunityNotes?: bool|null,
 *   exclusiveContent?: TweetExclusiveContent|array<string,mixed>|null,
 *   grokShareAttachment?: array<string,mixed>|null,
 *   grokTranslatedPost?: array<string,mixed>|null,
 *   jetfuelAttachment?: array<string,mixed>|null,
 *   coordinates?: TweetPoint|array<string,mixed>|null,
 *   geo?: TweetPoint|array<string,mixed>|null,
 *   postCta?: array<string,mixed>|null,
 *   reactionContext?: ReactionContext|array<string,mixed>|null,
 *   sportsContext?: SportsContext|array<string,mixed>|null,
 *   liveEventContext?: LiveEventContext|array<string,mixed>|null,
 *   subscriberBadge?: TweetSubscriberBadge|array<string,mixed>|null,
 *   tombstone?: TweetTombstone|array<string,mixed>|null,
 *   interstitial?: TweetInterstitial|array<string,mixed>|null,
 *   softIntervention?: SoftIntervention|array<string,mixed>|null,
 *   unmentionedUserIDs?: list<string>|null,
 *   scopes?: array<string,mixed>|null,
 *   unknownFields?: list<UnknownFields|value-of<UnknownFields>>|null,
 *   unknownCounts?: list<UnknownCounts|value-of<UnknownCounts>>|null,
 *   parentTweet?: array<string,mixed>|null,
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

    #[Optional('conversationId')]
    public ?string $conversationID;

    #[Optional]
    public ?string $createdAt;

    /** @var list<int>|null $displayTextRange */
    #[Optional(list: 'int')]
    public ?array $displayTextRange;

    /**
     * Edit history metadata returned by X.
     */
    #[Optional]
    public ?Edit $edit;

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
    public ?bool $isTranslatable;

    #[Optional]
    public ?string $lang;

    /** @var list<TweetMedia>|null $media */
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

    #[Optional]
    public ?string $source;

    #[Optional]
    public ?string $type;

    #[Optional]
    public ?string $url;

    #[Optional]
    public ?string $viewState;

    #[Optional]
    public ?bool $isPinned;

    #[Optional]
    public ?bool $isRetweet;

    #[Optional('quotedTweetId')]
    public ?string $quotedTweetID;

    /**
     * The quoted post's link, kept when X withholds that post.
     */
    #[Optional]
    public ?QuotedTweetPermalink $quotedTweetPermalink;

    /**
     * Why X shows no quoted post. Omitted when X names no reason.
     */
    #[Optional]
    public ?QuotedTweetUnavailable $quotedTweetUnavailable;

    /**
     * Repost event time in UTC. Null when unavailable. Omitted for other posts.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $retweetedAt;

    /**
     * Reply policy & conversation owner.
     */
    #[Optional]
    public ?ConversationControl $conversationControl;

    /**
     * Public restrictions & prompts.
     *
     * @var list<LimitedActions>|null $limitedActions
     */
    #[Optional(list: LimitedActions::class)]
    public ?array $limitedActions;

    /**
     * Where `text` matches the search, on each row a search read. Offsets count code points of `text`, as `displayTextRange` does. Empty when the post holds no marked match. Highlights cover a post's first 280 characters.
     *
     * @var list<TextHighlights>|null $textHighlights
     */
    #[Optional(list: TextHighlights::class)]
    public ?array $textHighlights;

    /**
     * Why the tweet has no author. X serves a suspended or deleted account as an unavailable user with a reason such as Suspended or NotFound. Omitted when the author is available.
     */
    #[Optional]
    public ?TweetAuthorUnavailable $authorUnavailable;

    /**
     * The author's ID when X withholds the author's profile.
     */
    #[Optional('unavailableAuthorId')]
    public ?string $unavailableAuthorID;

    /**
     * Price charts the author attached under the post, 1 per cashtag. Absent when the post has none. X may send a cashtag without a chart window.
     *
     * @var list<CashtagAttachments>|null $cashtagAttachments
     */
    #[Optional(list: CashtagAttachments::class)]
    public ?array $cashtagAttachments;

    /**
     * Community ID.
     */
    #[Optional('communityId')]
    public ?string $communityID;

    /**
     * Community name. Present when X sends it with the post.
     */
    #[Optional]
    public ?string $communityName;

    /**
     * Whether X holds Community Notes on the post, shown or not.
     */
    #[Optional]
    public ?bool $hasCommunityNotes;

    /**
     * Marks a subscriber-only post with the creator whose subscription unlocks it. Non-subscribers get the preview text & the subscribe link. Omitted on public posts.
     */
    #[Optional]
    public ?TweetExclusiveContent $exclusiveContent;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $grokShareAttachment
     */
    #[Optional(map: 'mixed')]
    public ?array $grokShareAttachment;

    /**
     * Grok's translation of the post, as X shows it.
     *
     * @var array<string,mixed>|null $grokTranslatedPost
     */
    #[Optional(map: 'mixed')]
    public ?array $grokTranslatedPost;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $jetfuelAttachment
     */
    #[Optional(map: 'mixed')]
    public ?array $jetfuelAttachment;

    /**
     * Author-published point, with longitude before latitude.
     */
    #[Optional]
    public ?TweetPoint $coordinates;

    /**
     * Author-published point, with latitude before longitude.
     */
    #[Optional]
    public ?TweetPoint $geo;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $postCta
     */
    #[Optional(map: 'mixed')]
    public ?array $postCta;

    /**
     * Public post & user this reaction references.
     */
    #[Optional]
    public ?ReactionContext $reactionContext;

    /**
     * Game metadata attached to this post.
     */
    #[Optional]
    public ?SportsContext $sportsContext;

    /**
     * The live event the post belongs to, such as an election.
     */
    #[Optional]
    public ?LiveEventContext $liveEventContext;

    /**
     * The Subscriber badge X shows on a reply. The reply's author subscribes to the creator who started the conversation. Omitted on a post without the badge.
     */
    #[Optional]
    public ?TweetSubscriberBadge $subscriberBadge;

    /**
     * Public visibility notice attached to an available tweet.
     */
    #[Optional]
    public ?TweetTombstone $tombstone;

    /**
     * The notice x.com covers the post with until someone chooses to view it, such as X's public interest notice on a post that broke its rules but stays up.
     */
    #[Optional]
    public ?TweetInterstitial $interstitial;

    /**
     * The label X shows under a post whose reach it limits. It links to the page that explains it.
     */
    #[Optional]
    public ?SoftIntervention $softIntervention;

    /**
     * User IDs that left this conversation.
     *
     * @var list<string>|null $unmentionedUserIDs
     */
    #[Optional('unmentionedUserIds', list: 'string')]
    public ?array $unmentionedUserIDs;

    /**
     * Public metadata whose fields X defines.
     *
     * @var array<string,mixed>|null $scopes
     */
    #[Optional(map: 'mixed')]
    public ?array $scopes;

    /**
     * The fields X did not send for this post. text reads empty, so treat it as unknown rather than empty. Left out when X sent the text.
     *
     * @var list<value-of<UnknownFields>>|null $unknownFields
     */
    #[Optional(list: UnknownFields::class)]
    public ?array $unknownFields;

    /**
     * The counts X did not send for this post. Each one reads 0, so treat it as unknown rather than none. Names follow the response's key style, so `xquik-api-contract: 2026-04-29` lists bookmark_count. Posts from before X counted views, & new posts X has not counted views for yet, list viewCount. Left out when X sent every count. Counts X didn't send are listed in `unknownCounts`, never shown as 0.
     *
     * @var list<value-of<UnknownCounts>>|null $unknownCounts
     */
    #[Optional(list: UnknownCounts::class)]
    public ?array $unknownCounts;

    /**
     * The post this one replies to, with the same fields.
     *
     * @var array<string,mixed>|null $parentTweet
     */
    #[Optional(map: 'mixed')]
    public ?array $parentTweet;

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
     * @param QuotedTweetPermalink|array<string,mixed>|null $quotedTweetPermalink
     * @param QuotedTweetUnavailable|array<string,mixed>|null $quotedTweetUnavailable
     * @param ConversationControl|array<string,mixed>|null $conversationControl
     * @param list<LimitedActions|array<string,mixed>>|null $limitedActions
     * @param list<TextHighlights|array<string,mixed>>|null $textHighlights
     * @param TweetAuthorUnavailable|array<string,mixed>|null $authorUnavailable
     * @param list<CashtagAttachments|array<string,mixed>>|null $cashtagAttachments
     * @param TweetExclusiveContent|array<string,mixed>|null $exclusiveContent
     * @param array<string,mixed>|null $grokShareAttachment
     * @param array<string,mixed>|null $grokTranslatedPost
     * @param array<string,mixed>|null $jetfuelAttachment
     * @param TweetPoint|array<string,mixed>|null $coordinates
     * @param TweetPoint|array<string,mixed>|null $geo
     * @param array<string,mixed>|null $postCta
     * @param ReactionContext|array<string,mixed>|null $reactionContext
     * @param SportsContext|array<string,mixed>|null $sportsContext
     * @param LiveEventContext|array<string,mixed>|null $liveEventContext
     * @param TweetSubscriberBadge|array<string,mixed>|null $subscriberBadge
     * @param TweetTombstone|array<string,mixed>|null $tombstone
     * @param TweetInterstitial|array<string,mixed>|null $interstitial
     * @param SoftIntervention|array<string,mixed>|null $softIntervention
     * @param list<string>|null $unmentionedUserIDs
     * @param array<string,mixed>|null $scopes
     * @param list<UnknownFields|value-of<UnknownFields>>|null $unknownFields
     * @param list<UnknownCounts|value-of<UnknownCounts>>|null $unknownCounts
     * @param array<string,mixed>|null $parentTweet
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
        ?EmbeddedTweet $quotedTweet = null,
        ?EmbeddedTweet $retweetedTweet = null,
        ?string $source = null,
        ?string $type = null,
        ?string $url = null,
        ?string $viewState = null,
        ?bool $isPinned = null,
        ?bool $isRetweet = null,
        ?string $quotedTweetID = null,
        QuotedTweetPermalink|array|null $quotedTweetPermalink = null,
        QuotedTweetUnavailable|array|null $quotedTweetUnavailable = null,
        ?\DateTimeInterface $retweetedAt = null,
        ConversationControl|array|null $conversationControl = null,
        ?array $limitedActions = null,
        ?array $textHighlights = null,
        TweetAuthorUnavailable|array|null $authorUnavailable = null,
        ?string $unavailableAuthorID = null,
        ?array $cashtagAttachments = null,
        ?string $communityID = null,
        ?string $communityName = null,
        ?bool $hasCommunityNotes = null,
        TweetExclusiveContent|array|null $exclusiveContent = null,
        ?array $grokShareAttachment = null,
        ?array $grokTranslatedPost = null,
        ?array $jetfuelAttachment = null,
        TweetPoint|array|null $coordinates = null,
        TweetPoint|array|null $geo = null,
        ?array $postCta = null,
        ReactionContext|array|null $reactionContext = null,
        SportsContext|array|null $sportsContext = null,
        LiveEventContext|array|null $liveEventContext = null,
        TweetSubscriberBadge|array|null $subscriberBadge = null,
        TweetTombstone|array|null $tombstone = null,
        TweetInterstitial|array|null $interstitial = null,
        SoftIntervention|array|null $softIntervention = null,
        ?array $unmentionedUserIDs = null,
        ?array $scopes = null,
        ?array $unknownFields = null,
        ?array $unknownCounts = null,
        ?array $parentTweet = null
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

        null !== $isPinned && $self['isPinned'] = $isPinned;

        null !== $isRetweet && $self['isRetweet'] = $isRetweet;

        null !== $quotedTweetID && $self['quotedTweetID'] = $quotedTweetID;

        null !== $quotedTweetPermalink && $self['quotedTweetPermalink'] = $quotedTweetPermalink;

        null !== $quotedTweetUnavailable && $self['quotedTweetUnavailable'] = $quotedTweetUnavailable;

        null !== $retweetedAt && $self['retweetedAt'] = $retweetedAt;

        null !== $conversationControl && $self['conversationControl'] = $conversationControl;

        null !== $limitedActions && $self['limitedActions'] = $limitedActions;

        null !== $textHighlights && $self['textHighlights'] = $textHighlights;

        null !== $authorUnavailable && $self['authorUnavailable'] = $authorUnavailable;

        null !== $unavailableAuthorID && $self['unavailableAuthorID'] = $unavailableAuthorID;

        null !== $cashtagAttachments && $self['cashtagAttachments'] = $cashtagAttachments;

        null !== $communityID && $self['communityID'] = $communityID;

        null !== $communityName && $self['communityName'] = $communityName;

        null !== $hasCommunityNotes && $self['hasCommunityNotes'] = $hasCommunityNotes;

        null !== $exclusiveContent && $self['exclusiveContent'] = $exclusiveContent;

        null !== $grokShareAttachment && $self['grokShareAttachment'] = $grokShareAttachment;

        null !== $grokTranslatedPost && $self['grokTranslatedPost'] = $grokTranslatedPost;

        null !== $jetfuelAttachment && $self['jetfuelAttachment'] = $jetfuelAttachment;

        null !== $coordinates && $self['coordinates'] = $coordinates;

        null !== $geo && $self['geo'] = $geo;

        null !== $postCta && $self['postCta'] = $postCta;

        null !== $reactionContext && $self['reactionContext'] = $reactionContext;

        null !== $sportsContext && $self['sportsContext'] = $sportsContext;

        null !== $liveEventContext && $self['liveEventContext'] = $liveEventContext;

        null !== $subscriberBadge && $self['subscriberBadge'] = $subscriberBadge;

        null !== $tombstone && $self['tombstone'] = $tombstone;

        null !== $interstitial && $self['interstitial'] = $interstitial;

        null !== $softIntervention && $self['softIntervention'] = $softIntervention;

        null !== $unmentionedUserIDs && $self['unmentionedUserIDs'] = $unmentionedUserIDs;

        null !== $scopes && $self['scopes'] = $scopes;

        null !== $unknownFields && $self['unknownFields'] = $unknownFields;

        null !== $unknownCounts && $self['unknownCounts'] = $unknownCounts;

        null !== $parentTweet && $self['parentTweet'] = $parentTweet;

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

    public function withIsTranslatable(bool $isTranslatable): self
    {
        $self = clone $this;
        $self['isTranslatable'] = $isTranslatable;

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
     */
    public function withQuotedTweet(EmbeddedTweet $quotedTweet): self
    {
        $self = clone $this;
        $self['quotedTweet'] = $quotedTweet;

        return $self;
    }

    /**
     * Quoted or retweeted tweet context. Every object includes id, text, and engagement metrics. A zero metric can mean X did not report the count. Author, media, and conversation fields appear when available.
     */
    public function withRetweetedTweet(EmbeddedTweet $retweetedTweet): self
    {
        $self = clone $this;
        $self['retweetedTweet'] = $retweetedTweet;

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

    public function withViewState(string $viewState): self
    {
        $self = clone $this;
        $self['viewState'] = $viewState;

        return $self;
    }

    public function withIsPinned(?bool $isPinned): self
    {
        $self = clone $this;
        $self['isPinned'] = $isPinned;

        return $self;
    }

    public function withIsRetweet(?bool $isRetweet): self
    {
        $self = clone $this;
        $self['isRetweet'] = $isRetweet;

        return $self;
    }

    public function withQuotedTweetID(?string $quotedTweetID): self
    {
        $self = clone $this;
        $self['quotedTweetID'] = $quotedTweetID;

        return $self;
    }

    /**
     * The quoted post's link, kept when X withholds that post.
     *
     * @param QuotedTweetPermalink|array<string,mixed>|null $quotedTweetPermalink
     */
    public function withQuotedTweetPermalink(QuotedTweetPermalink|array|null $quotedTweetPermalink): self
    {
        $self = clone $this;
        $self['quotedTweetPermalink'] = $quotedTweetPermalink;

        return $self;
    }

    /**
     * Why X shows no quoted post. Omitted when X names no reason.
     *
     * @param QuotedTweetUnavailable|array<string,mixed>|null $quotedTweetUnavailable
     */
    public function withQuotedTweetUnavailable(QuotedTweetUnavailable|array|null $quotedTweetUnavailable): self
    {
        $self = clone $this;
        $self['quotedTweetUnavailable'] = $quotedTweetUnavailable;

        return $self;
    }

    /**
     * Repost event time in UTC. Null when unavailable. Omitted for other posts.
     */
    public function withRetweetedAt(?\DateTimeInterface $retweetedAt): self
    {
        $self = clone $this;
        $self['retweetedAt'] = $retweetedAt;

        return $self;
    }

    /**
     * Reply policy & conversation owner.
     *
     * @param ConversationControl|array<string,mixed>|null $conversationControl
     */
    public function withConversationControl(ConversationControl|array|null $conversationControl): self
    {
        $self = clone $this;
        $self['conversationControl'] = $conversationControl;

        return $self;
    }

    /**
     * Public restrictions & prompts.
     *
     * @param list<LimitedActions|array<string,mixed>>|null $limitedActions
     */
    public function withLimitedActions(?array $limitedActions): self
    {
        $self = clone $this;
        $self['limitedActions'] = $limitedActions;

        return $self;
    }

    /**
     * Where `text` matches the search, on each row a search read. Offsets count code points of `text`, as `displayTextRange` does. Empty when the post holds no marked match. Highlights cover a post's first 280 characters.
     *
     * @param list<TextHighlights|array<string,mixed>>|null $textHighlights
     */
    public function withTextHighlights(?array $textHighlights): self
    {
        $self = clone $this;
        $self['textHighlights'] = $textHighlights;

        return $self;
    }

    /**
     * Why the tweet has no author. X serves a suspended or deleted account as an unavailable user with a reason such as Suspended or NotFound. Omitted when the author is available.
     *
     * @param TweetAuthorUnavailable|array<string,mixed>|null $authorUnavailable
     */
    public function withAuthorUnavailable(TweetAuthorUnavailable|array|null $authorUnavailable): self
    {
        $self = clone $this;
        $self['authorUnavailable'] = $authorUnavailable;

        return $self;
    }

    /**
     * The author's ID when X withholds the author's profile.
     */
    public function withUnavailableAuthorID(?string $unavailableAuthorID): self
    {
        $self = clone $this;
        $self['unavailableAuthorID'] = $unavailableAuthorID;

        return $self;
    }

    /**
     * Price charts the author attached under the post, 1 per cashtag. Absent when the post has none. X may send a cashtag without a chart window.
     *
     * @param list<CashtagAttachments|array<string,mixed>>|null $cashtagAttachments
     */
    public function withCashtagAttachments(?array $cashtagAttachments): self
    {
        $self = clone $this;
        $self['cashtagAttachments'] = $cashtagAttachments;

        return $self;
    }

    /**
     * Community ID.
     */
    public function withCommunityID(?string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    /**
     * Community name. Present when X sends it with the post.
     */
    public function withCommunityName(?string $communityName): self
    {
        $self = clone $this;
        $self['communityName'] = $communityName;

        return $self;
    }

    /**
     * Whether X holds Community Notes on the post, shown or not.
     */
    public function withHasCommunityNotes(?bool $hasCommunityNotes): self
    {
        $self = clone $this;
        $self['hasCommunityNotes'] = $hasCommunityNotes;

        return $self;
    }

    /**
     * Marks a subscriber-only post with the creator whose subscription unlocks it. Non-subscribers get the preview text & the subscribe link. Omitted on public posts.
     *
     * @param TweetExclusiveContent|array<string,mixed>|null $exclusiveContent
     */
    public function withExclusiveContent(TweetExclusiveContent|array|null $exclusiveContent): self
    {
        $self = clone $this;
        $self['exclusiveContent'] = $exclusiveContent;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $grokShareAttachment
     */
    public function withGrokShareAttachment(?array $grokShareAttachment): self
    {
        $self = clone $this;
        $self['grokShareAttachment'] = $grokShareAttachment;

        return $self;
    }

    /**
     * Grok's translation of the post, as X shows it.
     *
     * @param array<string,mixed>|null $grokTranslatedPost
     */
    public function withGrokTranslatedPost(?array $grokTranslatedPost): self
    {
        $self = clone $this;
        $self['grokTranslatedPost'] = $grokTranslatedPost;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $jetfuelAttachment
     */
    public function withJetfuelAttachment(?array $jetfuelAttachment): self
    {
        $self = clone $this;
        $self['jetfuelAttachment'] = $jetfuelAttachment;

        return $self;
    }

    /**
     * Author-published point, with longitude before latitude.
     *
     * @param TweetPoint|array<string,mixed>|null $coordinates
     */
    public function withCoordinates(TweetPoint|array|null $coordinates): self
    {
        $self = clone $this;
        $self['coordinates'] = $coordinates;

        return $self;
    }

    /**
     * Author-published point, with latitude before longitude.
     *
     * @param TweetPoint|array<string,mixed>|null $geo
     */
    public function withGeo(TweetPoint|array|null $geo): self
    {
        $self = clone $this;
        $self['geo'] = $geo;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $postCta
     */
    public function withPostCta(?array $postCta): self
    {
        $self = clone $this;
        $self['postCta'] = $postCta;

        return $self;
    }

    /**
     * Public post & user this reaction references.
     *
     * @param ReactionContext|array<string,mixed>|null $reactionContext
     */
    public function withReactionContext(ReactionContext|array|null $reactionContext): self
    {
        $self = clone $this;
        $self['reactionContext'] = $reactionContext;

        return $self;
    }

    /**
     * Game metadata attached to this post.
     *
     * @param SportsContext|array<string,mixed>|null $sportsContext
     */
    public function withSportsContext(SportsContext|array|null $sportsContext): self
    {
        $self = clone $this;
        $self['sportsContext'] = $sportsContext;

        return $self;
    }

    /**
     * The live event the post belongs to, such as an election.
     *
     * @param LiveEventContext|array<string,mixed>|null $liveEventContext
     */
    public function withLiveEventContext(LiveEventContext|array|null $liveEventContext): self
    {
        $self = clone $this;
        $self['liveEventContext'] = $liveEventContext;

        return $self;
    }

    /**
     * The Subscriber badge X shows on a reply. The reply's author subscribes to the creator who started the conversation. Omitted on a post without the badge.
     *
     * @param TweetSubscriberBadge|array<string,mixed>|null $subscriberBadge
     */
    public function withSubscriberBadge(TweetSubscriberBadge|array|null $subscriberBadge): self
    {
        $self = clone $this;
        $self['subscriberBadge'] = $subscriberBadge;

        return $self;
    }

    /**
     * Public visibility notice attached to an available tweet.
     *
     * @param TweetTombstone|array<string,mixed>|null $tombstone
     */
    public function withTombstone(TweetTombstone|array|null $tombstone): self
    {
        $self = clone $this;
        $self['tombstone'] = $tombstone;

        return $self;
    }

    /**
     * The notice x.com covers the post with until someone chooses to view it, such as X's public interest notice on a post that broke its rules but stays up.
     *
     * @param TweetInterstitial|array<string,mixed>|null $interstitial
     */
    public function withInterstitial(TweetInterstitial|array|null $interstitial): self
    {
        $self = clone $this;
        $self['interstitial'] = $interstitial;

        return $self;
    }

    /**
     * The label X shows under a post whose reach it limits. It links to the page that explains it.
     *
     * @param SoftIntervention|array<string,mixed>|null $softIntervention
     */
    public function withSoftIntervention(SoftIntervention|array|null $softIntervention): self
    {
        $self = clone $this;
        $self['softIntervention'] = $softIntervention;

        return $self;
    }

    /**
     * User IDs that left this conversation.
     *
     * @param list<string>|null $unmentionedUserIDs
     */
    public function withUnmentionedUserIDs(?array $unmentionedUserIDs): self
    {
        $self = clone $this;
        $self['unmentionedUserIDs'] = $unmentionedUserIDs;

        return $self;
    }

    /**
     * Public metadata whose fields X defines.
     *
     * @param array<string,mixed>|null $scopes
     */
    public function withScopes(?array $scopes): self
    {
        $self = clone $this;
        $self['scopes'] = $scopes;

        return $self;
    }

    /**
     * The fields X did not send for this post. text reads empty, so treat it as unknown rather than empty. Left out when X sent the text.
     *
     * @param list<UnknownFields|value-of<UnknownFields>>|null $unknownFields
     */
    public function withUnknownFields(?array $unknownFields): self
    {
        $self = clone $this;
        $self['unknownFields'] = $unknownFields;

        return $self;
    }

    /**
     * The counts X did not send for this post. Each one reads 0, so treat it as unknown rather than none. Names follow the response's key style, so `xquik-api-contract: 2026-04-29` lists bookmark_count. Posts from before X counted views, & new posts X has not counted views for yet, list viewCount. Left out when X sent every count. Counts X didn't send are listed in `unknownCounts`, never shown as 0.
     *
     * @param list<UnknownCounts|value-of<UnknownCounts>>|null $unknownCounts
     */
    public function withUnknownCounts(?array $unknownCounts): self
    {
        $self = clone $this;
        $self['unknownCounts'] = $unknownCounts;

        return $self;
    }

    /**
     * The post this one replies to, with the same fields.
     *
     * @param array<string,mixed>|null $parentTweet
     */
    public function withParentTweet(?array $parentTweet): self
    {
        $self = clone $this;
        $self['parentTweet'] = $parentTweet;

        return $self;
    }
}
