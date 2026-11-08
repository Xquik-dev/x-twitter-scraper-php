<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams\MediaType;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams\Mode;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams\Quotes;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams\Replies;
use XTwitterScraper\X\Users\UserRetrieveTweetsParams\Retweets;

/**
 * Omit mode for automatic maximum coverage. Pass next_cursor unchanged. Unprefixed cursors use legacy pagination. Shape and billing stay the same.
 *
 * @see XTwitterScraper\Services\X\UsersService::retrieveTweets()
 *
 * @phpstan-type UserRetrieveTweetsParamsShape = array{
 *   anyWords?: string|null,
 *   blueVerifiedOnly?: bool|null,
 *   cardName?: string|null,
 *   cashtags?: string|null,
 *   conversationID?: string|null,
 *   cursor?: string|null,
 *   exactPhrase?: string|null,
 *   excludeSource?: string|null,
 *   excludeWords?: string|null,
 *   fromUser?: string|null,
 *   geocode?: string|null,
 *   hashtags?: string|null,
 *   imageShows?: string|null,
 *   includeParentTweet?: bool|null,
 *   includeReplies?: bool|null,
 *   inReplyToTweetID?: string|null,
 *   language?: string|null,
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
 *   sinceDate?: string|null,
 *   sinceID?: string|null,
 *   source?: string|null,
 *   topic?: string|null,
 *   toUser?: string|null,
 *   untilDate?: string|null,
 *   url?: string|null,
 *   verifiedOnly?: bool|null,
 *   within?: string|null,
 *   withinTime?: string|null,
 *   mode?: Mode|value-of<Mode>|null,
 *   sinceTime?: string|null,
 *   untilTime?: string|null,
 *   minLikes?: int|null,
 *   keywords?: string|null,
 *   listID?: string|null,
 *   place?: string|null,
 *   placeCountry?: string|null,
 *   pointRadius?: string|null,
 *   boundingBox?: string|null,
 *   advancedQuery?: string|null,
 *   fields?: string|null,
 *   omit?: string|null,
 * }
 */
final class UserRetrieveTweetsParams implements BaseModel
{
    /** @use SdkModel<UserRetrieveTweetsParamsShape> */
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
     * Keep only posts whose photos show this. Send charts, screenshots, product_photos, memes or people, or describe it in words, such as a rocket. AI-powered analysis checks posts with photos X doesn't mark sensitive & keeps scores of 0.5 or more. Other posts stay out at no charge. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. imageFilter states the cutoff & counts.
     */
    #[Optional]
    public ?string $imageShows;

    /**
     * Include parent tweet for replies.
     */
    #[Optional]
    public ?bool $includeParentTweet;

    /**
     * Include reply tweets.
     */
    #[Optional]
    public ?bool $includeReplies;

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
     * Match the source application.
     */
    #[Optional]
    public ?string $source;

    /**
     * Keep only posts about this topic. AI-powered analysis asks "Is this post about <topic>?" of each post & keeps scores of 0.5 or more. It reads post text & safe photos. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. limit counts checked posts, & only kept posts come back. topicFilter states the cutoff & counts.
     */
    #[Optional]
    public ?string $topic;

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

    /**
     * Optional legacy pagination override. Filters such as keywords don't apply with it.
     *
     * @var value-of<Mode>|null $mode
     */
    #[Optional(enum: Mode::class)]
    public ?string $mode;

    /**
     * Inclusive ISO bound for Tweet creation time, such as 2026-09-25T19:20:41Z. Unix seconds also work. A time without an offset is UTC.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * Exclusive ISO bound for Tweet creation time. Unix seconds also work. A time without an offset is UTC.
     */
    #[Optional]
    public ?string $untilTime;

    /**
     * Minimum likes. Its aliases are minFaves, min_likes & min_faves.
     */
    #[Optional]
    public ?int $minLikes;

    /**
     * Words the Tweets must match, in X search syntax.
     */
    #[Optional]
    public ?string $keywords;

    /**
     * Search within a list ID.
     */
    #[Optional('listId')]
    public ?string $listID;

    /**
     * Search within a place ID.
     */
    #[Optional]
    public ?string $place;

    /**
     * Search within a country code.
     */
    #[Optional]
    public ?string $placeCountry;

    /**
     * Geo point radius, such as -73.99 40.73 25mi.
     */
    #[Optional]
    public ?string $pointRadius;

    /**
     * Geo bounding box, such as -74.1 40.6 -73.9 40.8.
     */
    #[Optional]
    public ?string $boundingBox;

    /**
     * Raw advanced search query appended as-is.
     */
    #[Optional]
    public ?string $advancedQuery;

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
     * @param Quotes|value-of<Quotes>|null $quotes
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     * @param Mode|value-of<Mode>|null $mode
     */
    public static function with(
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?string $imageShows = null,
        ?bool $includeParentTweet = null,
        ?bool $includeReplies = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
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
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $source = null,
        ?string $topic = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
        ?string $within = null,
        ?string $withinTime = null,
        Mode|string|null $mode = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
        ?int $minLikes = null,
        ?string $keywords = null,
        ?string $listID = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        ?string $boundingBox = null,
        ?string $advancedQuery = null,
        ?string $fields = null,
        ?string $omit = null
    ): self {
        $self = new self;

        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;
        null !== $cardName && $self['cardName'] = $cardName;
        null !== $cashtags && $self['cashtags'] = $cashtags;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeSource && $self['excludeSource'] = $excludeSource;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $fromUser && $self['fromUser'] = $fromUser;
        null !== $geocode && $self['geocode'] = $geocode;
        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $imageShows && $self['imageShows'] = $imageShows;
        null !== $includeParentTweet && $self['includeParentTweet'] = $includeParentTweet;
        null !== $includeReplies && $self['includeReplies'] = $includeReplies;
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $language && $self['language'] = $language;
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
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $sinceID && $self['sinceID'] = $sinceID;
        null !== $source && $self['source'] = $source;
        null !== $topic && $self['topic'] = $topic;
        null !== $toUser && $self['toUser'] = $toUser;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $url && $self['url'] = $url;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $within && $self['within'] = $within;
        null !== $withinTime && $self['withinTime'] = $withinTime;

        null !== $mode && $self['mode'] = $mode;

        null !== $sinceTime && $self['sinceTime'] = $sinceTime;

        null !== $untilTime && $self['untilTime'] = $untilTime;

        null !== $minLikes && $self['minLikes'] = $minLikes;

        null !== $keywords && $self['keywords'] = $keywords;

        null !== $listID && $self['listID'] = $listID;

        null !== $place && $self['place'] = $place;

        null !== $placeCountry && $self['placeCountry'] = $placeCountry;

        null !== $pointRadius && $self['pointRadius'] = $pointRadius;

        null !== $boundingBox && $self['boundingBox'] = $boundingBox;

        null !== $advancedQuery && $self['advancedQuery'] = $advancedQuery;

        null !== $fields && $self['fields'] = $fields;

        null !== $omit && $self['omit'] = $omit;

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
     * Keep only posts whose photos show this. Send charts, screenshots, product_photos, memes or people, or describe it in words, such as a rocket. AI-powered analysis checks posts with photos X doesn't mark sensitive & keeps scores of 0.5 or more. Other posts stay out at no charge. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. imageFilter states the cutoff & counts.
     */
    public function withImageShows(string $imageShows): self
    {
        $self = clone $this;
        $self['imageShows'] = $imageShows;

        return $self;
    }

    /**
     * Include parent tweet for replies.
     */
    public function withIncludeParentTweet(bool $includeParentTweet): self
    {
        $self = clone $this;
        $self['includeParentTweet'] = $includeParentTweet;

        return $self;
    }

    /**
     * Include reply tweets.
     */
    public function withIncludeReplies(bool $includeReplies): self
    {
        $self = clone $this;
        $self['includeReplies'] = $includeReplies;

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
     * Match the source application.
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Keep only posts about this topic. AI-powered analysis asks "Is this post about <topic>?" of each post & keeps scores of 0.5 or more. It reads post text & safe photos. Each kept post costs 2 credits, the AI analysis price, instead of the read price, & a post the filter drops costs nothing. limit counts checked posts, & only kept posts come back. topicFilter states the cutoff & counts.
     */
    public function withTopic(string $topic): self
    {
        $self = clone $this;
        $self['topic'] = $topic;

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

    /**
     * Optional legacy pagination override. Filters such as keywords don't apply with it.
     *
     * @param Mode|value-of<Mode>|null $mode
     */
    public function withMode(Mode|string|null $mode): self
    {
        $self = clone $this;
        $self['mode'] = $mode;

        return $self;
    }

    /**
     * Inclusive ISO bound for Tweet creation time, such as 2026-09-25T19:20:41Z. Unix seconds also work. A time without an offset is UTC.
     */
    public function withSinceTime(?string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Exclusive ISO bound for Tweet creation time. Unix seconds also work. A time without an offset is UTC.
     */
    public function withUntilTime(?string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

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
     * Words the Tweets must match, in X search syntax.
     */
    public function withKeywords(?string $keywords): self
    {
        $self = clone $this;
        $self['keywords'] = $keywords;

        return $self;
    }

    /**
     * Search within a list ID.
     */
    public function withListID(?string $listID): self
    {
        $self = clone $this;
        $self['listID'] = $listID;

        return $self;
    }

    /**
     * Search within a place ID.
     */
    public function withPlace(?string $place): self
    {
        $self = clone $this;
        $self['place'] = $place;

        return $self;
    }

    /**
     * Search within a country code.
     */
    public function withPlaceCountry(?string $placeCountry): self
    {
        $self = clone $this;
        $self['placeCountry'] = $placeCountry;

        return $self;
    }

    /**
     * Geo point radius, such as -73.99 40.73 25mi.
     */
    public function withPointRadius(?string $pointRadius): self
    {
        $self = clone $this;
        $self['pointRadius'] = $pointRadius;

        return $self;
    }

    /**
     * Geo bounding box, such as -74.1 40.6 -73.9 40.8.
     */
    public function withBoundingBox(?string $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

        return $self;
    }

    /**
     * Raw advanced search query appended as-is.
     */
    public function withAdvancedQuery(?string $advancedQuery): self
    {
        $self = clone $this;
        $self['advancedQuery'] = $advancedQuery;

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
