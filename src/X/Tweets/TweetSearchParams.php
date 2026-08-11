<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetSearchParams\MediaType;
use XTwitterScraper\X\Tweets\TweetSearchParams\Mode;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchParams\Quotes;
use XTwitterScraper\X\Tweets\TweetSearchParams\Replies;
use XTwitterScraper\X\Tweets\TweetSearchParams\Retweets;

/**
 * No-mode search maximizes coverage.
 *
 * @see XTwitterScraper\Services\X\TweetsService::search()
 *
 * @phpstan-type TweetSearchParamsShape = array{
 *   q: string,
 *   advancedQuery?: string|null,
 *   anyWords?: string|null,
 *   blueVerifiedOnly?: bool|null,
 *   boundingBox?: string|null,
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
 *   inReplyToTweetID?: string|null,
 *   language?: string|null,
 *   limit?: int|null,
 *   listID?: string|null,
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
 *   place?: string|null,
 *   placeCountry?: string|null,
 *   pointRadius?: string|null,
 *   queryType?: null|QueryType|value-of<QueryType>,
 *   quotes?: null|Quotes|value-of<Quotes>,
 *   quotesOfTweetID?: string|null,
 *   replies?: null|Replies|value-of<Replies>,
 *   retweets?: null|Retweets|value-of<Retweets>,
 *   retweetsOfTweetID?: string|null,
 *   safe?: bool|null,
 *   sinceDate?: string|null,
 *   sinceID?: string|null,
 *   sinceTime?: string|null,
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
final class TweetSearchParams implements BaseModel
{
    /** @use SdkModel<TweetSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Query, Tweet ID, or status URL. Valid inline bounds apply per page.
     */
    #[Required]
    public string $q;

    /**
     * Raw advanced search query appended as-is.
     */
    #[Optional]
    public ?string $advancedQuery;

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
     * Geo bounding box, e.g. -74.1 40.6 -73.9 40.8.
     */
    #[Optional]
    public ?string $boundingBox;

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
     * Result upper bound. Omit it for the existing 20-row page size. Explicit coverage defaults to 2000 and allows 10000. For paid requests, remaining credits can reduce results. Zero affordable results returns 402.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Search within a list ID.
     */
    #[Optional]
    public ?string $listID;

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
     * Minimum likes threshold.
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
     * Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
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
     * Geo point radius, e.g. -73.99 40.73 25mi.
     */
    #[Optional]
    public ?string $pointRadius;

    /**
     * Sort order - Latest (chronological) or Top (engagement-ranked).
     *
     * @var value-of<QueryType>|null $queryType
     */
    #[Optional(enum: QueryType::class)]
    public ?string $queryType;

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
     * Inclusive ISO bound.
     */
    #[Optional]
    public ?string $sinceTime;

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
     * Exclusive ISO bound.
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

    /**
     * `new TweetSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetSearchParams)->withQ(...)
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
     * @param MediaType|value-of<MediaType>|null $mediaType
     * @param Mode|value-of<Mode>|null $mode
     * @param QueryType|value-of<QueryType>|null $queryType
     * @param Quotes|value-of<Quotes>|null $quotes
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     */
    public static function with(
        string $q,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?bool $blueVerifiedOnly = null,
        ?string $boundingBox = null,
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
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $limit = null,
        ?string $listID = null,
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
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        QueryType|string|null $queryType = null,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        ?string $sinceTime = null,
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

        $self['q'] = $q;

        null !== $advancedQuery && $self['advancedQuery'] = $advancedQuery;
        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;
        null !== $boundingBox && $self['boundingBox'] = $boundingBox;
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
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $language && $self['language'] = $language;
        null !== $limit && $self['limit'] = $limit;
        null !== $listID && $self['listID'] = $listID;
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
        null !== $place && $self['place'] = $place;
        null !== $placeCountry && $self['placeCountry'] = $placeCountry;
        null !== $pointRadius && $self['pointRadius'] = $pointRadius;
        null !== $queryType && $self['queryType'] = $queryType;
        null !== $quotes && $self['quotes'] = $quotes;
        null !== $quotesOfTweetID && $self['quotesOfTweetID'] = $quotesOfTweetID;
        null !== $replies && $self['replies'] = $replies;
        null !== $retweets && $self['retweets'] = $retweets;
        null !== $retweetsOfTweetID && $self['retweetsOfTweetID'] = $retweetsOfTweetID;
        null !== $safe && $self['safe'] = $safe;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $sinceID && $self['sinceID'] = $sinceID;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
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
     * Query, Tweet ID, or status URL. Valid inline bounds apply per page.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Raw advanced search query appended as-is.
     */
    public function withAdvancedQuery(string $advancedQuery): self
    {
        $self = clone $this;
        $self['advancedQuery'] = $advancedQuery;

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
     * Geo bounding box, e.g. -74.1 40.6 -73.9 40.8.
     */
    public function withBoundingBox(string $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

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
     * Result upper bound. Omit it for the existing 20-row page size. Explicit coverage defaults to 2000 and allows 10000. For paid requests, remaining credits can reduce results. Zero affordable results returns 402.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Search within a list ID.
     */
    public function withListID(string $listID): self
    {
        $self = clone $this;
        $self['listID'] = $listID;

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
     * Minimum likes threshold.
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
     * Omit mode for resumable maximum coverage. Standard keeps legacy pagination. Coverage returns diagnostics once and rejects cursors.
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
     * Search within a place ID.
     */
    public function withPlace(string $place): self
    {
        $self = clone $this;
        $self['place'] = $place;

        return $self;
    }

    /**
     * Search within a country code.
     */
    public function withPlaceCountry(string $placeCountry): self
    {
        $self = clone $this;
        $self['placeCountry'] = $placeCountry;

        return $self;
    }

    /**
     * Geo point radius, e.g. -73.99 40.73 25mi.
     */
    public function withPointRadius(string $pointRadius): self
    {
        $self = clone $this;
        $self['pointRadius'] = $pointRadius;

        return $self;
    }

    /**
     * Sort order - Latest (chronological) or Top (engagement-ranked).
     *
     * @param QueryType|value-of<QueryType> $queryType
     */
    public function withQueryType(QueryType|string $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

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
     * Inclusive ISO bound.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

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
     * Exclusive ISO bound.
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
