<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\MediaType;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Mode;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Quotes;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Replies;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Retweets;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Scope;
use XTwitterScraper\X\Tweets\TweetGetRepliesParams\Sort;

/**
 * Returns direct replies. Omit mode for automatic maximum coverage with resumable pagination. Complete mode returns nested replies, diagnostics, and 424 when direct coverage stays below 80%.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getReplies()
 *
 * @phpstan-type TweetGetRepliesParamsShape = array{
 *   anyWords?: string|null,
 *   blueVerifiedOnly?: bool|null,
 *   cardName?: string|null,
 *   cashtags?: string|null,
 *   conversationID?: string|null,
 *   cursor?: string|null,
 *   exactPhrase?: string|null,
 *   excludeOriginalAuthor?: bool|null,
 *   excludeSource?: string|null,
 *   excludeWords?: string|null,
 *   fromUser?: string|null,
 *   geocode?: string|null,
 *   hashtags?: string|null,
 *   hasMediaOnly?: bool|null,
 *   includeOriginalPost?: bool|null,
 *   inReplyToTweetID?: string|null,
 *   language?: string|null,
 *   limit?: int|null,
 *   maxDepth?: int|null,
 *   maxFaves?: int|null,
 *   maxID?: string|null,
 *   maxQuotes?: int|null,
 *   maxReplies?: int|null,
 *   maxRetweets?: int|null,
 *   mediaType?: null|MediaType|value-of<MediaType>,
 *   mentioning?: string|null,
 *   minBookmarks?: int|null,
 *   minFaves?: int|null,
 *   minQuotes?: int|null,
 *   minReplies?: int|null,
 *   minRetweets?: int|null,
 *   minViews?: int|null,
 *   mode?: null|Mode|value-of<Mode>,
 *   nativeRetweets?: bool|null,
 *   near?: string|null,
 *   news?: bool|null,
 *   pageSize?: int|null,
 *   quotes?: null|Quotes|value-of<Quotes>,
 *   quotesOfTweetID?: string|null,
 *   replies?: null|Replies|value-of<Replies>,
 *   retweets?: null|Retweets|value-of<Retweets>,
 *   retweetsOfTweetID?: string|null,
 *   safe?: bool|null,
 *   scope?: null|Scope|value-of<Scope>,
 *   sinceDate?: string|null,
 *   sinceID?: string|null,
 *   sinceTime?: string|null,
 *   sort?: null|Sort|value-of<Sort>,
 *   source?: string|null,
 *   toUser?: string|null,
 *   untilDate?: string|null,
 *   untilTime?: string|null,
 *   url?: string|null,
 *   verifiedOnly?: bool|null,
 *   within?: string|null,
 *   withinTime?: string|null,
 * }
 */
final class TweetGetRepliesParams implements BaseModel
{
    /** @use SdkModel<TweetGetRepliesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $anyWords;

    /**
     * Only return tweets from Blue-verified authors.
     */
    #[Optional]
    public ?bool $blueVerifiedOnly;

    /**
     * Match the Tweet card name.
     */
    #[Optional]
    public ?string $cardName;

    /**
     * Cashtags separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $cashtags;

    /**
     * Conversation ID filter.
     */
    #[Optional]
    public ?string $conversationID;

    /**
     * Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Exact phrase to match.
     */
    #[Optional]
    public ?string $exactPhrase;

    /**
     * Exclude replies written by the source-post author.
     */
    #[Optional]
    public ?bool $excludeOriginalAuthor;

    /**
     * Exclude a source application.
     */
    #[Optional]
    public ?string $excludeSource;

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $excludeWords;

    /**
     * Filter by author username.
     */
    #[Optional]
    public ?string $fromUser;

    /**
     * Match latitude, longitude, and radius.
     */
    #[Optional]
    public ?string $geocode;

    /**
     * Hashtags separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $hashtags;

    /**
     * Only return replies containing media.
     */
    #[Optional]
    public ?bool $hasMediaOnly;

    /**
     * Include the source post and count it toward limit.
     */
    #[Optional]
    public ?bool $includeOriginalPost;

    /**
     * Only replies to this tweet ID.
     */
    #[Optional]
    public ?string $inReplyToTweetID;

    /**
     * Language code filter, e.g. en or tr.
     */
    #[Optional]
    public ?string $language;

    /**
     * With mode=complete, maximum combined direct and nested reply rows (1-25000, default 25000). Automatic pages accept 1-300. Standard pages accept 1-100. Prefer pageSize outside complete mode.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Maximum reply depth from the source post.
     */
    #[Optional]
    public ?int $maxDepth;

    /**
     * Maximum likes threshold. maxLikes is also accepted.
     */
    #[Optional]
    public ?int $maxFaves;

    /**
     * Return Tweets older than this Tweet ID.
     */
    #[Optional]
    public ?string $maxID;

    /**
     * Maximum quotes threshold.
     */
    #[Optional]
    public ?int $maxQuotes;

    /**
     * Maximum replies threshold.
     */
    #[Optional]
    public ?int $maxReplies;

    /**
     * Maximum retweets threshold.
     */
    #[Optional]
    public ?int $maxRetweets;

    /**
     * Filter by media type.
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Filter tweets mentioning a username.
     */
    #[Optional]
    public ?string $mentioning;

    /**
     * Minimum bookmark count threshold.
     */
    #[Optional]
    public ?int $minBookmarks;

    /**
     * Minimum likes threshold. minLikes is also accepted.
     */
    #[Optional]
    public ?int $minFaves;

    /**
     * Minimum quote count threshold.
     */
    #[Optional]
    public ?int $minQuotes;

    /**
     * Minimum replies threshold.
     */
    #[Optional]
    public ?int $minReplies;

    /**
     * Minimum retweets threshold.
     */
    #[Optional]
    public ?int $minRetweets;

    /**
     * Minimum view count threshold.
     */
    #[Optional]
    public ?int $minViews;

    /**
     * Optional advanced override. Omit mode for automatic maximum direct reply coverage with pagination. Standard keeps legacy pagination. Complete returns direct and nested replies with diagnostics, scope, depth, sorting, and original-post controls.
     *
     * @var value-of<Mode>|null $mode
     */
    #[Optional(enum: Mode::class)]
    public ?string $mode;

    /**
     * Only return native reposts.
     */
    #[Optional]
    public ?bool $nativeRetweets;

    /**
     * Match a place name.
     */
    #[Optional]
    public ?string $near;

    /**
     * Only return news results.
     */
    #[Optional]
    public ?bool $news;

    /**
     * Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Quote mode.
     *
     * @var value-of<Quotes>|null $quotes
     */
    #[Optional(enum: Quotes::class)]
    public ?string $quotes;

    /**
     * Only quotes of this tweet ID.
     */
    #[Optional]
    public ?string $quotesOfTweetID;

    /**
     * Reply mode.
     *
     * @var value-of<Replies>|null $replies
     */
    #[Optional(enum: Replies::class)]
    public ?string $replies;

    /**
     * Retweet mode.
     *
     * @var value-of<Retweets>|null $retweets
     */
    #[Optional(enum: Retweets::class)]
    public ?string $retweets;

    /**
     * Only retweets of this tweet ID.
     */
    #[Optional]
    public ?string $retweetsOfTweetID;

    /**
     * Enable the safe-search filter.
     */
    #[Optional]
    public ?bool $safe;

    /**
     * Select all replies, direct replies, or nested replies.
     *
     * @var value-of<Scope>|null $scope
     */
    #[Optional(enum: Scope::class)]
    public ?string $scope;

    /**
     * Start date in YYYY-MM-DD format.
     */
    #[Optional]
    public ?string $sinceDate;

    /**
     * Return Tweets newer than this Tweet ID.
     */
    #[Optional]
    public ?string $sinceID;

    /**
     * Unix timestamp - return replies posted after this time.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * Sort the selected replies before applying limit.
     *
     * @var value-of<Sort>|null $sort
     */
    #[Optional(enum: Sort::class)]
    public ?string $sort;

    /**
     * Match the source application.
     */
    #[Optional]
    public ?string $source;

    /**
     * Filter replies sent to a username.
     */
    #[Optional]
    public ?string $toUser;

    /**
     * End date in YYYY-MM-DD format.
     */
    #[Optional]
    public ?string $untilDate;

    /**
     * Unix timestamp - return replies posted before this time.
     */
    #[Optional]
    public ?string $untilTime;

    /**
     * URL substring or domain filter.
     */
    #[Optional]
    public ?string $url;

    /**
     * Only return tweets from verified authors.
     */
    #[Optional]
    public ?bool $verifiedOnly;

    /**
     * Set the radius for the near filter.
     */
    #[Optional]
    public ?string $within;

    /**
     * Match Tweets inside a recent time window.
     */
    #[Optional]
    public ?string $withinTime;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MediaType|value-of<MediaType>|null $mediaType
     * @param Mode|value-of<Mode>|null $mode
     * @param Quotes|value-of<Quotes>|null $quotes
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     * @param Scope|value-of<Scope>|null $scope
     * @param Sort|value-of<Sort>|null $sort
     */
    public static function with(
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?bool $excludeOriginalAuthor = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?bool $hasMediaOnly = null,
        ?bool $includeOriginalPost = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $limit = null,
        ?int $maxDepth = null,
        ?int $maxFaves = null,
        ?string $maxID = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        Mode|string|null $mode = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        ?int $pageSize = null,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        Scope|string|null $scope = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $sinceTime = null,
        Sort|string|null $sort = null,
        ?string $source = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
    ): self {
        $self = new self;

        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;
        null !== $cardName && $self['cardName'] = $cardName;
        null !== $cashtags && $self['cashtags'] = $cashtags;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeOriginalAuthor && $self['excludeOriginalAuthor'] = $excludeOriginalAuthor;
        null !== $excludeSource && $self['excludeSource'] = $excludeSource;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $fromUser && $self['fromUser'] = $fromUser;
        null !== $geocode && $self['geocode'] = $geocode;
        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $hasMediaOnly && $self['hasMediaOnly'] = $hasMediaOnly;
        null !== $includeOriginalPost && $self['includeOriginalPost'] = $includeOriginalPost;
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $language && $self['language'] = $language;
        null !== $limit && $self['limit'] = $limit;
        null !== $maxDepth && $self['maxDepth'] = $maxDepth;
        null !== $maxFaves && $self['maxFaves'] = $maxFaves;
        null !== $maxID && $self['maxID'] = $maxID;
        null !== $maxQuotes && $self['maxQuotes'] = $maxQuotes;
        null !== $maxReplies && $self['maxReplies'] = $maxReplies;
        null !== $maxRetweets && $self['maxRetweets'] = $maxRetweets;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $mentioning && $self['mentioning'] = $mentioning;
        null !== $minBookmarks && $self['minBookmarks'] = $minBookmarks;
        null !== $minFaves && $self['minFaves'] = $minFaves;
        null !== $minQuotes && $self['minQuotes'] = $minQuotes;
        null !== $minReplies && $self['minReplies'] = $minReplies;
        null !== $minRetweets && $self['minRetweets'] = $minRetweets;
        null !== $minViews && $self['minViews'] = $minViews;
        null !== $mode && $self['mode'] = $mode;
        null !== $nativeRetweets && $self['nativeRetweets'] = $nativeRetweets;
        null !== $near && $self['near'] = $near;
        null !== $news && $self['news'] = $news;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $quotes && $self['quotes'] = $quotes;
        null !== $quotesOfTweetID && $self['quotesOfTweetID'] = $quotesOfTweetID;
        null !== $replies && $self['replies'] = $replies;
        null !== $retweets && $self['retweets'] = $retweets;
        null !== $retweetsOfTweetID && $self['retweetsOfTweetID'] = $retweetsOfTweetID;
        null !== $safe && $self['safe'] = $safe;
        null !== $scope && $self['scope'] = $scope;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $sinceID && $self['sinceID'] = $sinceID;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $sort && $self['sort'] = $sort;
        null !== $source && $self['source'] = $source;
        null !== $toUser && $self['toUser'] = $toUser;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $untilTime && $self['untilTime'] = $untilTime;
        null !== $url && $self['url'] = $url;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $within && $self['within'] = $within;
        null !== $withinTime && $self['withinTime'] = $withinTime;

        return $self;
    }

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     */
    public function withAnyWords(string $anyWords): self
    {
        $self = clone $this;
        $self['anyWords'] = $anyWords;

        return $self;
    }

    /**
     * Only return tweets from Blue-verified authors.
     */
    public function withBlueVerifiedOnly(bool $blueVerifiedOnly): self
    {
        $self = clone $this;
        $self['blueVerifiedOnly'] = $blueVerifiedOnly;

        return $self;
    }

    /**
     * Match the Tweet card name.
     */
    public function withCardName(string $cardName): self
    {
        $self = clone $this;
        $self['cardName'] = $cardName;

        return $self;
    }

    /**
     * Cashtags separated by spaces, commas, or lines.
     */
    public function withCashtags(string $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * Conversation ID filter.
     */
    public function withConversationID(string $conversationID): self
    {
        $self = clone $this;
        $self['conversationID'] = $conversationID;

        return $self;
    }

    /**
     * Cursor from the previous response. Xquik cursors resume automatic coverage. Existing unprefixed cursors keep legacy standard behavior.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Exact phrase to match.
     */
    public function withExactPhrase(string $exactPhrase): self
    {
        $self = clone $this;
        $self['exactPhrase'] = $exactPhrase;

        return $self;
    }

    /**
     * Exclude replies written by the source-post author.
     */
    public function withExcludeOriginalAuthor(bool $excludeOriginalAuthor): self
    {
        $self = clone $this;
        $self['excludeOriginalAuthor'] = $excludeOriginalAuthor;

        return $self;
    }

    /**
     * Exclude a source application.
     */
    public function withExcludeSource(string $excludeSource): self
    {
        $self = clone $this;
        $self['excludeSource'] = $excludeSource;

        return $self;
    }

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     */
    public function withExcludeWords(string $excludeWords): self
    {
        $self = clone $this;
        $self['excludeWords'] = $excludeWords;

        return $self;
    }

    /**
     * Filter by author username.
     */
    public function withFromUser(string $fromUser): self
    {
        $self = clone $this;
        $self['fromUser'] = $fromUser;

        return $self;
    }

    /**
     * Match latitude, longitude, and radius.
     */
    public function withGeocode(string $geocode): self
    {
        $self = clone $this;
        $self['geocode'] = $geocode;

        return $self;
    }

    /**
     * Hashtags separated by spaces, commas, or lines.
     */
    public function withHashtags(string $hashtags): self
    {
        $self = clone $this;
        $self['hashtags'] = $hashtags;

        return $self;
    }

    /**
     * Only return replies containing media.
     */
    public function withHasMediaOnly(bool $hasMediaOnly): self
    {
        $self = clone $this;
        $self['hasMediaOnly'] = $hasMediaOnly;

        return $self;
    }

    /**
     * Include the source post and count it toward limit.
     */
    public function withIncludeOriginalPost(bool $includeOriginalPost): self
    {
        $self = clone $this;
        $self['includeOriginalPost'] = $includeOriginalPost;

        return $self;
    }

    /**
     * Only replies to this tweet ID.
     */
    public function withInReplyToTweetID(string $inReplyToTweetID): self
    {
        $self = clone $this;
        $self['inReplyToTweetID'] = $inReplyToTweetID;

        return $self;
    }

    /**
     * Language code filter, e.g. en or tr.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * With mode=complete, maximum combined direct and nested reply rows (1-25000, default 25000). Automatic pages accept 1-300. Standard pages accept 1-100. Prefer pageSize outside complete mode.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Maximum reply depth from the source post.
     */
    public function withMaxDepth(int $maxDepth): self
    {
        $self = clone $this;
        $self['maxDepth'] = $maxDepth;

        return $self;
    }

    /**
     * Maximum likes threshold. maxLikes is also accepted.
     */
    public function withMaxFaves(int $maxFaves): self
    {
        $self = clone $this;
        $self['maxFaves'] = $maxFaves;

        return $self;
    }

    /**
     * Return Tweets older than this Tweet ID.
     */
    public function withMaxID(string $maxID): self
    {
        $self = clone $this;
        $self['maxID'] = $maxID;

        return $self;
    }

    /**
     * Maximum quotes threshold.
     */
    public function withMaxQuotes(int $maxQuotes): self
    {
        $self = clone $this;
        $self['maxQuotes'] = $maxQuotes;

        return $self;
    }

    /**
     * Maximum replies threshold.
     */
    public function withMaxReplies(int $maxReplies): self
    {
        $self = clone $this;
        $self['maxReplies'] = $maxReplies;

        return $self;
    }

    /**
     * Maximum retweets threshold.
     */
    public function withMaxRetweets(int $maxRetweets): self
    {
        $self = clone $this;
        $self['maxRetweets'] = $maxRetweets;

        return $self;
    }

    /**
     * Filter by media type.
     *
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Filter tweets mentioning a username.
     */
    public function withMentioning(string $mentioning): self
    {
        $self = clone $this;
        $self['mentioning'] = $mentioning;

        return $self;
    }

    /**
     * Minimum bookmark count threshold.
     */
    public function withMinBookmarks(int $minBookmarks): self
    {
        $self = clone $this;
        $self['minBookmarks'] = $minBookmarks;

        return $self;
    }

    /**
     * Minimum likes threshold. minLikes is also accepted.
     */
    public function withMinFaves(int $minFaves): self
    {
        $self = clone $this;
        $self['minFaves'] = $minFaves;

        return $self;
    }

    /**
     * Minimum quote count threshold.
     */
    public function withMinQuotes(int $minQuotes): self
    {
        $self = clone $this;
        $self['minQuotes'] = $minQuotes;

        return $self;
    }

    /**
     * Minimum replies threshold.
     */
    public function withMinReplies(int $minReplies): self
    {
        $self = clone $this;
        $self['minReplies'] = $minReplies;

        return $self;
    }

    /**
     * Minimum retweets threshold.
     */
    public function withMinRetweets(int $minRetweets): self
    {
        $self = clone $this;
        $self['minRetweets'] = $minRetweets;

        return $self;
    }

    /**
     * Minimum view count threshold.
     */
    public function withMinViews(int $minViews): self
    {
        $self = clone $this;
        $self['minViews'] = $minViews;

        return $self;
    }

    /**
     * Optional advanced override. Omit mode for automatic maximum direct reply coverage with pagination. Standard keeps legacy pagination. Complete returns direct and nested replies with diagnostics, scope, depth, sorting, and original-post controls.
     *
     * @param Mode|value-of<Mode> $mode
     */
    public function withMode(Mode|string $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * Only return native reposts.
     */
    public function withNativeRetweets(bool $nativeRetweets): self
    {
        $self = clone $this;
        $self['nativeRetweets'] = $nativeRetweets;

        return $self;
    }

    /**
     * Match a place name.
     */
    public function withNear(string $near): self
    {
        $self = clone $this;
        $self['near'] = $near;

        return $self;
    }

    /**
     * Only return news results.
     */
    public function withNews(bool $news): self
    {
        $self = clone $this;
        $self['news'] = $news;

        return $self;
    }

    /**
     * Automatic pages accept 1-300 Tweets. Standard pages keep 1-100. Default 20. Continue while has_next_page is true. Deprecated aliases remain accepted.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Quote mode.
     *
     * @param Quotes|value-of<Quotes> $quotes
     */
    public function withQuotes(Quotes|string $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    /**
     * Only quotes of this tweet ID.
     */
    public function withQuotesOfTweetID(string $quotesOfTweetID): self
    {
        $self = clone $this;
        $self['quotesOfTweetID'] = $quotesOfTweetID;

        return $self;
    }

    /**
     * Reply mode.
     *
     * @param Replies|value-of<Replies> $replies
     */
    public function withReplies(Replies|string $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * Retweet mode.
     *
     * @param Retweets|value-of<Retweets> $retweets
     */
    public function withRetweets(Retweets|string $retweets): self
    {
        $self = clone $this;
        $self['retweets'] = $retweets;

        return $self;
    }

    /**
     * Only retweets of this tweet ID.
     */
    public function withRetweetsOfTweetID(string $retweetsOfTweetID): self
    {
        $self = clone $this;
        $self['retweetsOfTweetID'] = $retweetsOfTweetID;

        return $self;
    }

    /**
     * Enable the safe-search filter.
     */
    public function withSafe(bool $safe): self
    {
        $self = clone $this;
        $self['safe'] = $safe;

        return $self;
    }

    /**
     * Select all replies, direct replies, or nested replies.
     *
     * @param Scope|value-of<Scope> $scope
     */
    public function withScope(Scope|string $scope): self
    {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * Start date in YYYY-MM-DD format.
     */
    public function withSinceDate(string $sinceDate): self
    {
        $self = clone $this;
        $self['sinceDate'] = $sinceDate;

        return $self;
    }

    /**
     * Return Tweets newer than this Tweet ID.
     */
    public function withSinceID(string $sinceID): self
    {
        $self = clone $this;
        $self['sinceID'] = $sinceID;

        return $self;
    }

    /**
     * Unix timestamp - return replies posted after this time.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Sort the selected replies before applying limit.
     *
     * @param Sort|value-of<Sort> $sort
     */
    public function withSort(Sort|string $sort): self
    {
        $self = clone $this;
        $self['sort'] = $sort;

        return $self;
    }

    /**
     * Match the source application.
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Filter replies sent to a username.
     */
    public function withToUser(string $toUser): self
    {
        $self = clone $this;
        $self['toUser'] = $toUser;

        return $self;
    }

    /**
     * End date in YYYY-MM-DD format.
     */
    public function withUntilDate(string $untilDate): self
    {
        $self = clone $this;
        $self['untilDate'] = $untilDate;

        return $self;
    }

    /**
     * Unix timestamp - return replies posted before this time.
     */
    public function withUntilTime(string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }

    /**
     * URL substring or domain filter.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Only return tweets from verified authors.
     */
    public function withVerifiedOnly(bool $verifiedOnly): self
    {
        $self = clone $this;
        $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }

    /**
     * Set the radius for the near filter.
     */
    public function withWithin(string $within): self
    {
        $self = clone $this;
        $self['within'] = $within;

        return $self;
    }

    /**
     * Match Tweets inside a recent time window.
     */
    public function withWithinTime(string $withinTime): self
    {
        $self = clone $this;
        $self['withinTime'] = $withinTime;

        return $self;
    }
}
