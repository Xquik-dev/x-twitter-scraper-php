<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Users\UserRetrieveHighlightsParams\MediaType;
use XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Quotes;
use XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Replies;
use XTwitterScraper\X\Users\UserRetrieveHighlightsParams\Retweets;

/**
 * Returns the posts on the user's Highlights tab, in X's order. An account without highlights returns an empty list.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveHighlights()
 *
 * @phpstan-type UserRetrieveHighlightsParamsShape = array{
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   fromUser?: string|null,
 *   toUser?: string|null,
 *   mentioning?: string|null,
 *   language?: string|null,
 *   sinceDate?: string|null,
 *   untilDate?: string|null,
 *   mediaType?: MediaType|value-of<MediaType>|null,
 *   minLikes?: int|null,
 *   minRetweets?: int|null,
 *   minReplies?: int|null,
 *   minQuotes?: int|null,
 *   minViews?: int|null,
 *   minBookmarks?: int|null,
 *   maxFaves?: int|null,
 *   maxRetweets?: int|null,
 *   maxReplies?: int|null,
 *   maxQuotes?: int|null,
 *   blueVerifiedOnly?: bool|null,
 *   sinceID?: string|null,
 *   maxID?: string|null,
 *   withinTime?: string|null,
 *   nativeRetweets?: bool|null,
 *   verifiedOnly?: bool|null,
 *   replies?: Replies|value-of<Replies>|null,
 *   retweets?: Retweets|value-of<Retweets>|null,
 *   quotes?: Quotes|value-of<Quotes>|null,
 *   exactPhrase?: string|null,
 *   excludeWords?: string|null,
 *   anyWords?: string|null,
 *   hashtags?: string|null,
 *   cashtags?: string|null,
 *   url?: string|null,
 *   conversationID?: string|null,
 *   inReplyToTweetID?: string|null,
 *   quotesOfTweetID?: string|null,
 *   retweetsOfTweetID?: string|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class UserRetrieveHighlightsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveHighlightsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Filter by author username. Account searches include all of the account's posts & reposts.
     */
    #[Optional]
    public ?string $fromUser;

    /**
     * Filter replies sent to a username.
     */
    #[Optional]
    public ?string $toUser;

    /**
     * Filter tweets mentioning a username.
     */
    #[Optional]
    public ?string $mentioning;

    /**
     * Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     */
    #[Optional]
    public ?string $language;

    /**
     * Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     */
    #[Optional]
    public ?string $sinceDate;

    /**
     * End date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count.
     */
    #[Optional]
    public ?string $untilDate;

    /**
     * Filter media. Its aliases are has_video & has_media.
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     */
    #[Optional]
    public ?int $minLikes;

    /**
     * Minimum retweets threshold.
     */
    #[Optional]
    public ?int $minRetweets;

    /**
     * Minimum replies threshold.
     */
    #[Optional]
    public ?int $minReplies;

    /**
     * Minimum quote count threshold.
     */
    #[Optional]
    public ?int $minQuotes;

    /**
     * Minimum view count threshold.
     */
    #[Optional]
    public ?int $minViews;

    /**
     * Minimum bookmark count threshold.
     */
    #[Optional]
    public ?int $minBookmarks;

    /**
     * Maximum likes threshold. maxLikes & max_likes also work.
     */
    #[Optional]
    public ?int $maxFaves;

    /**
     * Maximum retweets threshold.
     */
    #[Optional]
    public ?int $maxRetweets;

    /**
     * Maximum replies threshold.
     */
    #[Optional]
    public ?int $maxReplies;

    /**
     * Maximum quotes threshold.
     */
    #[Optional]
    public ?int $maxQuotes;

    /**
     * Only return tweets from Blue-verified authors.
     */
    #[Optional]
    public ?bool $blueVerifiedOnly;

    /**
     * Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     */
    #[Optional('sinceId')]
    public ?string $sinceID;

    /**
     * Return Tweets at or below this ID.
     */
    #[Optional('maxId')]
    public ?string $maxID;

    /**
     * Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     */
    #[Optional]
    public ?string $withinTime;

    /**
     * Only return native reposts.
     */
    #[Optional]
    public ?bool $nativeRetweets;

    /**
     * Only return tweets from verified authors.
     */
    #[Optional]
    public ?bool $verifiedOnly;

    /**
     * Reply mode. Exclude keeps own-thread replies.
     *
     * @var value-of<Replies>|null $replies
     */
    #[Optional(enum: Replies::class)]
    public ?string $replies;

    /**
     * Only when the caller requests a repost mode.
     *
     * @var value-of<Retweets>|null $retweets
     */
    #[Optional(enum: Retweets::class)]
    public ?string $retweets;

    /**
     * Only when the caller requests a quote mode.
     *
     * @var value-of<Quotes>|null $quotes
     */
    #[Optional(enum: Quotes::class)]
    public ?string $quotes;

    /**
     * Match this exact phrase, word for word.
     */
    #[Optional]
    public ?string $exactPhrase;

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $excludeWords;

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $anyWords;

    /**
     * Hashtags separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $hashtags;

    /**
     * Cashtags separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $cashtags;

    /**
     * URL substring or domain filter.
     */
    #[Optional]
    public ?string $url;

    /**
     * Conversation ID filter.
     */
    #[Optional('conversationId')]
    public ?string $conversationID;

    /**
     * Only replies to this tweet ID.
     */
    #[Optional('inReplyToTweetId')]
    public ?string $inReplyToTweetID;

    /**
     * Only quotes of this tweet ID.
     */
    #[Optional('quotesOfTweetId')]
    public ?string $quotesOfTweetID;

    /**
     * Only retweets of this tweet ID.
     */
    #[Optional('retweetsOfTweetId')]
    public ?string $retweetsOfTweetID;

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    #[Optional]
    public ?string $fields;

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    #[Optional]
    public ?string $omit;

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
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     * @param Quotes|value-of<Quotes>|null $quotes
     */
    public static function with(?string $cursor = null, ?int $pageSize = null, ?string $fromUser = null, ?string $toUser = null, ?string $mentioning = null, ?string $language = null, ?string $sinceDate = null, ?string $untilDate = null, MediaType|string|null $mediaType = null, ?int $minLikes = null, ?int $minRetweets = null, ?int $minReplies = null, ?int $minQuotes = null, ?int $minViews = null, ?int $minBookmarks = null, ?int $maxFaves = null, ?int $maxRetweets = null, ?int $maxReplies = null, ?int $maxQuotes = null, ?bool $blueVerifiedOnly = null, ?string $sinceID = null, ?string $maxID = null, ?string $withinTime = null, ?bool $nativeRetweets = null, ?bool $verifiedOnly = null, Replies|string|null $replies = null, Retweets|string|null $retweets = null, Quotes|string|null $quotes = null, ?string $exactPhrase = null, ?string $excludeWords = null, ?string $anyWords = null, ?string $hashtags = null, ?string $cashtags = null, ?string $url = null, ?string $conversationID = null, ?string $inReplyToTweetID = null, ?string $quotesOfTweetID = null, ?string $retweetsOfTweetID = null, ?string $fields = null, ?string $omit = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $fromUser && $self['fromUser'] = $fromUser;
        null !== $toUser && $self['toUser'] = $toUser;
        null !== $mentioning && $self['mentioning'] = $mentioning;
        null !== $language && $self['language'] = $language;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $minLikes && $self['minLikes'] = $minLikes;
        null !== $minRetweets && $self['minRetweets'] = $minRetweets;
        null !== $minReplies && $self['minReplies'] = $minReplies;
        null !== $minQuotes && $self['minQuotes'] = $minQuotes;
        null !== $minViews && $self['minViews'] = $minViews;
        null !== $minBookmarks && $self['minBookmarks'] = $minBookmarks;
        null !== $maxFaves && $self['maxFaves'] = $maxFaves;
        null !== $maxRetweets && $self['maxRetweets'] = $maxRetweets;
        null !== $maxReplies && $self['maxReplies'] = $maxReplies;
        null !== $maxQuotes && $self['maxQuotes'] = $maxQuotes;
        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;
        null !== $sinceID && $self['sinceID'] = $sinceID;
        null !== $maxID && $self['maxID'] = $maxID;
        null !== $withinTime && $self['withinTime'] = $withinTime;
        null !== $nativeRetweets && $self['nativeRetweets'] = $nativeRetweets;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $replies && $self['replies'] = $replies;
        null !== $retweets && $self['retweets'] = $retweets;
        null !== $quotes && $self['quotes'] = $quotes;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $cashtags && $self['cashtags'] = $cashtags;
        null !== $url && $self['url'] = $url;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $quotesOfTweetID && $self['quotesOfTweetID'] = $quotesOfTweetID;
        null !== $retweetsOfTweetID && $self['retweetsOfTweetID'] = $retweetsOfTweetID;
        null !== $fields && $self['fields'] = $fields;
        null !== $omit && $self['omit'] = $omit;

        return $self;
    }

    /**
     * Pagination cursor for collection results. Also read as next_cursor, next_token, pagination_token or continuation_token.
     */
    public function withCursor(?string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Items per page (1-100, default 20). Source, filters or credits can return fewer. Follow next_cursor for more pages. Its aliases are limit, count, max_results, maxItems, max_items & per_page.
     */
    public function withPageSize(?int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Filter by author username. Account searches include all of the account's posts & reposts.
     */
    public function withFromUser(?string $fromUser): self
    {
        $self = clone $this;
        $self['fromUser'] = $fromUser;

        return $self;
    }

    /**
     * Filter replies sent to a username.
     */
    public function withToUser(?string $toUser): self
    {
        $self = clone $this;
        $self['toUser'] = $toUser;

        return $self;
    }

    /**
     * Filter tweets mentioning a username.
     */
    public function withMentioning(?string $mentioning): self
    {
        $self = clone $this;
        $self['mentioning'] = $mentioning;

        return $self;
    }

    /**
     * Filter by language. Its alias is `lang`. Language filters work for every language X tags.
     */
    public function withLanguage(?string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Start date in YYYY-MM-DD format, as a UTC day. A date means one thing in any common form.
     */
    public function withSinceDate(?string $sinceDate): self
    {
        $self = clone $this;
        $self['sinceDate'] = $sinceDate;

        return $self;
    }

    /**
     * End date in YYYY-MM-DD format, as a UTC day, inclusive, so its own posts count.
     */
    public function withUntilDate(?string $untilDate): self
    {
        $self = clone $this;
        $self['untilDate'] = $untilDate;

        return $self;
    }

    /**
     * Filter media. Its aliases are has_video & has_media.
     *
     * @param MediaType|value-of<MediaType>|null $mediaType
     */
    public function withMediaType(MediaType|string|null $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     */
    public function withMinLikes(?int $minLikes): self
    {
        $self = clone $this;
        $self['minLikes'] = $minLikes;

        return $self;
    }

    /**
     * Minimum retweets threshold.
     */
    public function withMinRetweets(?int $minRetweets): self
    {
        $self = clone $this;
        $self['minRetweets'] = $minRetweets;

        return $self;
    }

    /**
     * Minimum replies threshold.
     */
    public function withMinReplies(?int $minReplies): self
    {
        $self = clone $this;
        $self['minReplies'] = $minReplies;

        return $self;
    }

    /**
     * Minimum quote count threshold.
     */
    public function withMinQuotes(?int $minQuotes): self
    {
        $self = clone $this;
        $self['minQuotes'] = $minQuotes;

        return $self;
    }

    /**
     * Minimum view count threshold.
     */
    public function withMinViews(?int $minViews): self
    {
        $self = clone $this;
        $self['minViews'] = $minViews;

        return $self;
    }

    /**
     * Minimum bookmark count threshold.
     */
    public function withMinBookmarks(?int $minBookmarks): self
    {
        $self = clone $this;
        $self['minBookmarks'] = $minBookmarks;

        return $self;
    }

    /**
     * Maximum likes threshold. maxLikes & max_likes also work.
     */
    public function withMaxFaves(?int $maxFaves): self
    {
        $self = clone $this;
        $self['maxFaves'] = $maxFaves;

        return $self;
    }

    /**
     * Maximum retweets threshold.
     */
    public function withMaxRetweets(?int $maxRetweets): self
    {
        $self = clone $this;
        $self['maxRetweets'] = $maxRetweets;

        return $self;
    }

    /**
     * Maximum replies threshold.
     */
    public function withMaxReplies(?int $maxReplies): self
    {
        $self = clone $this;
        $self['maxReplies'] = $maxReplies;

        return $self;
    }

    /**
     * Maximum quotes threshold.
     */
    public function withMaxQuotes(?int $maxQuotes): self
    {
        $self = clone $this;
        $self['maxQuotes'] = $maxQuotes;

        return $self;
    }

    /**
     * Only return tweets from Blue-verified authors.
     */
    public function withBlueVerifiedOnly(?bool $blueVerifiedOnly): self
    {
        $self = clone $this;
        $self['blueVerifiedOnly'] = $blueVerifiedOnly;

        return $self;
    }

    /**
     * Return Tweets whose IDs exceed this ID. Searches accept `since_id` & `max_id` bounds.
     */
    public function withSinceID(?string $sinceID): self
    {
        $self = clone $this;
        $self['sinceID'] = $sinceID;

        return $self;
    }

    /**
     * Return Tweets at or below this ID.
     */
    public function withMaxID(?string $maxID): self
    {
        $self = clone $this;
        $self['maxID'] = $maxID;

        return $self;
    }

    /**
     * Keeps Tweets from a recent window, such as 90m or 7d. Use a whole number & s, m, h or d.
     */
    public function withWithinTime(?string $withinTime): self
    {
        $self = clone $this;
        $self['withinTime'] = $withinTime;

        return $self;
    }

    /**
     * Only return native reposts.
     */
    public function withNativeRetweets(?bool $nativeRetweets): self
    {
        $self = clone $this;
        $self['nativeRetweets'] = $nativeRetweets;

        return $self;
    }

    /**
     * Only return tweets from verified authors.
     */
    public function withVerifiedOnly(?bool $verifiedOnly): self
    {
        $self = clone $this;
        $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }

    /**
     * Reply mode. Exclude keeps own-thread replies.
     *
     * @param Replies|value-of<Replies>|null $replies
     */
    public function withReplies(Replies|string|null $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * Only when the caller requests a repost mode.
     *
     * @param Retweets|value-of<Retweets>|null $retweets
     */
    public function withRetweets(Retweets|string|null $retweets): self
    {
        $self = clone $this;
        $self['retweets'] = $retweets;

        return $self;
    }

    /**
     * Only when the caller requests a quote mode.
     *
     * @param Quotes|value-of<Quotes>|null $quotes
     */
    public function withQuotes(Quotes|string|null $quotes): self
    {
        $self = clone $this;
        $self['quotes'] = $quotes;

        return $self;
    }

    /**
     * Match this exact phrase, word for word.
     */
    public function withExactPhrase(?string $exactPhrase): self
    {
        $self = clone $this;
        $self['exactPhrase'] = $exactPhrase;

        return $self;
    }

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines.
     */
    public function withExcludeWords(?string $excludeWords): self
    {
        $self = clone $this;
        $self['excludeWords'] = $excludeWords;

        return $self;
    }

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines.
     */
    public function withAnyWords(?string $anyWords): self
    {
        $self = clone $this;
        $self['anyWords'] = $anyWords;

        return $self;
    }

    /**
     * Hashtags separated by spaces, commas, or lines.
     */
    public function withHashtags(?string $hashtags): self
    {
        $self = clone $this;
        $self['hashtags'] = $hashtags;

        return $self;
    }

    /**
     * Cashtags separated by spaces, commas, or lines.
     */
    public function withCashtags(?string $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * URL substring or domain filter.
     */
    public function withUrl(?string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Conversation ID filter.
     */
    public function withConversationID(?string $conversationID): self
    {
        $self = clone $this;
        $self['conversationID'] = $conversationID;

        return $self;
    }

    /**
     * Only replies to this tweet ID.
     */
    public function withInReplyToTweetID(?string $inReplyToTweetID): self
    {
        $self = clone $this;
        $self['inReplyToTweetID'] = $inReplyToTweetID;

        return $self;
    }

    /**
     * Only quotes of this tweet ID.
     */
    public function withQuotesOfTweetID(?string $quotesOfTweetID): self
    {
        $self = clone $this;
        $self['quotesOfTweetID'] = $quotesOfTweetID;

        return $self;
    }

    /**
     * Only retweets of this tweet ID.
     */
    public function withRetweetsOfTweetID(?string $retweetsOfTweetID): self
    {
        $self = clone $this;
        $self['retweetsOfTweetID'] = $retweetsOfTweetID;

        return $self;
    }

    /**
     * Fields to keep in each row, comma-separated. Use dots for nested fields, such as author.username. A list keeps the field in each item. Case & underscores do not matter. A row that lacks a field leaves it out. Cursors, counts & diagnostics always stay. An unknown name answers 400 unknown_field with the valid names, before any read. The price stays the same. SDK row types then hold only the named fields. A longer URL fails at the edge before Xquik reads it. Pick only the fields you need with `fields` & `omit`.
     */
    public function withFields(?string $fields): self
    {
        $self = clone $this;
        $self['fields'] = $fields;

        return $self;
    }

    /**
     * Fields to drop from each row, comma-separated. It takes the same names as fields. With fields, it drops from the kept fields. A longer URL fails at the edge before Xquik reads it.
     */
    public function withOmit(?string $omit): self
    {
        $self = clone $this;
        $self['omit'] = $omit;

        return $self;
    }
}
