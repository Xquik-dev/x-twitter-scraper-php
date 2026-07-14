<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetSearchParams\MediaType;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;
use XTwitterScraper\X\Tweets\TweetSearchParams\Quotes;
use XTwitterScraper\X\Tweets\TweetSearchParams\Replies;
use XTwitterScraper\X\Tweets\TweetSearchParams\Retweets;

/**
 * Search tweets by query, Tweet ID, X status URL, or account date window.
 *
 * @see XTwitterScraper\Services\X\TweetsService::search()
 *
 * @phpstan-type TweetSearchParamsShape = array{
 *   q: string,
 *   advancedQuery?: string|null,
 *   anyWords?: string|null,
 *   boundingBox?: string|null,
 *   cashtags?: string|null,
 *   conversationID?: string|null,
 *   cursor?: string|null,
 *   exactPhrase?: string|null,
 *   excludeWords?: string|null,
 *   fromUser?: string|null,
 *   hashtags?: string|null,
 *   inReplyToTweetID?: string|null,
 *   language?: string|null,
 *   limit?: int|null,
 *   listID?: string|null,
 *   mediaType?: null|MediaType|value-of<MediaType>,
 *   mentioning?: string|null,
 *   minFaves?: int|null,
 *   minQuotes?: int|null,
 *   minReplies?: int|null,
 *   minRetweets?: int|null,
 *   place?: string|null,
 *   placeCountry?: string|null,
 *   pointRadius?: string|null,
 *   queryType?: null|QueryType|value-of<QueryType>,
 *   quotes?: null|Quotes|value-of<Quotes>,
 *   quotesOfTweetID?: string|null,
 *   replies?: null|Replies|value-of<Replies>,
 *   retweets?: null|Retweets|value-of<Retweets>,
 *   retweetsOfTweetID?: string|null,
 *   sinceDate?: string|null,
 *   sinceTime?: string|null,
 *   toUser?: string|null,
 *   untilDate?: string|null,
 *   untilTime?: string|null,
 *   url?: string|null,
 *   verifiedOnly?: bool|null,
 * }
 */
final class TweetSearchParams implements BaseModel
{
    /** @use SdkModel<TweetSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Search query (keywords,.
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
     * Geo bounding box, e.g. -74.1 40.6 -73.9 40.8.
     */
    #[Optional]
    public ?string $boundingBox;

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
     * Pagination cursor from previous response.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Exact phrase to match.
     */
    #[Optional]
    public ?string $exactPhrase;

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
     * Max tweets to return (server paginates internally). Omit for single page (~20). This is an upper bound for paid authenticated calls: remaining credits can reduce the returned page size, and zero affordable results returns 402 insufficient_credits.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Search within a list ID.
     */
    #[Optional]
    public ?string $listID;

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
     * Start date in YYYY-MM-DD format.
     */
    #[Optional]
    public ?string $sinceDate;

    /**
     * ISO 8601 timestamp - only return tweets after this time.
     */
    #[Optional]
    public ?string $sinceTime;

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
     * ISO 8601 timestamp - only return tweets before this time.
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
     * @param QueryType|value-of<QueryType>|null $queryType
     * @param Quotes|value-of<Quotes>|null $quotes
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     */
    public static function with(
        string $q,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $boundingBox = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $cursor = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?int $limit = null,
        ?string $listID = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minFaves = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        QueryType|string|null $queryType = null,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $sinceDate = null,
        ?string $sinceTime = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $untilTime = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
    ): self {
        $self = new self;

        $self['q'] = $q;

        null !== $advancedQuery && $self['advancedQuery'] = $advancedQuery;
        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $boundingBox && $self['boundingBox'] = $boundingBox;
        null !== $cashtags && $self['cashtags'] = $cashtags;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $fromUser && $self['fromUser'] = $fromUser;
        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $language && $self['language'] = $language;
        null !== $limit && $self['limit'] = $limit;
        null !== $listID && $self['listID'] = $listID;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $mentioning && $self['mentioning'] = $mentioning;
        null !== $minFaves && $self['minFaves'] = $minFaves;
        null !== $minQuotes && $self['minQuotes'] = $minQuotes;
        null !== $minReplies && $self['minReplies'] = $minReplies;
        null !== $minRetweets && $self['minRetweets'] = $minRetweets;
        null !== $place && $self['place'] = $place;
        null !== $placeCountry && $self['placeCountry'] = $placeCountry;
        null !== $pointRadius && $self['pointRadius'] = $pointRadius;
        null !== $queryType && $self['queryType'] = $queryType;
        null !== $quotes && $self['quotes'] = $quotes;
        null !== $quotesOfTweetID && $self['quotesOfTweetID'] = $quotesOfTweetID;
        null !== $replies && $self['replies'] = $replies;
        null !== $retweets && $self['retweets'] = $retweets;
        null !== $retweetsOfTweetID && $self['retweetsOfTweetID'] = $retweetsOfTweetID;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $toUser && $self['toUser'] = $toUser;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $untilTime && $self['untilTime'] = $untilTime;
        null !== $url && $self['url'] = $url;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }

    /**
     * Search query (keywords,.
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
     * Geo bounding box, e.g. -74.1 40.6 -73.9 40.8.
     */
    public function withBoundingBox(string $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

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
     * Pagination cursor from previous response.
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
     * Max tweets to return (server paginates internally). Omit for single page (~20). This is an upper bound for paid authenticated calls: remaining credits can reduce the returned page size, and zero affordable results returns 402 insufficient_credits.
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
     * Start date in YYYY-MM-DD format.
     */
    public function withSinceDate(string $sinceDate): self
    {
        $self = clone $this;
        $self['sinceDate'] = $sinceDate;

        return $self;
    }

    /**
     * ISO 8601 timestamp - only return tweets after this time.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

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
     * ISO 8601 timestamp - only return tweets before this time.
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
}
