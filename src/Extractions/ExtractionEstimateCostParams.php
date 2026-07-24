<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\MediaType;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Quotes;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Replies;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Retweets;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType;

/**
 * Estimate extraction cost.
 *
 * @see XTwitterScraper\Services\ExtractionsService::estimateCost()
 *
 * @phpstan-type ExtractionEstimateCostParamsShape = array{
 *   toolType: ToolType|value-of<ToolType>,
 *   advancedQuery?: string|null,
 *   anyWords?: string|null,
 *   boundingBox?: string|null,
 *   cashtags?: string|null,
 *   conversationID?: string|null,
 *   exactPhrase?: string|null,
 *   excludeWords?: string|null,
 *   fromUser?: string|null,
 *   hashtags?: string|null,
 *   inReplyToTweetID?: string|null,
 *   language?: string|null,
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
 *   quotes?: null|Quotes|value-of<Quotes>,
 *   quotesOfTweetID?: string|null,
 *   replies?: null|Replies|value-of<Replies>,
 *   resultsLimit?: int|null,
 *   retweets?: null|Retweets|value-of<Retweets>,
 *   retweetsOfTweetID?: string|null,
 *   searchQuery?: string|null,
 *   sinceDate?: string|null,
 *   targetCommunityID?: string|null,
 *   targetListID?: string|null,
 *   targetSpaceID?: string|null,
 *   targetTweetID?: string|null,
 *   targetUsername?: string|null,
 *   toUser?: string|null,
 *   untilDate?: string|null,
 *   url?: string|null,
 *   verifiedOnly?: bool|null,
 * }
 */
final class ExtractionEstimateCostParams implements BaseModel
{
    /** @use SdkModel<ExtractionEstimateCostParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @var value-of<ToolType> $toolType
     */
    #[Required(enum: ToolType::class)]
    public string $toolType;

    /**
     * Raw advanced query string appended to the estimate (tweet_search_extractor).
     */
    #[Optional]
    public ?string $advancedQuery;

    /**
     * Alternative words or quoted phrases for estimated results. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $anyWords;

    /**
     * Geo bounding box used for estimation, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor).
     */
    #[Optional]
    public ?string $boundingBox;

    /**
     * Cashtags applied to the estimate, separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $cashtags;

    /**
     * Conversation ID filter used for estimation (tweet_search_extractor).
     */
    #[Optional('conversationId')]
    public ?string $conversationID;

    /**
     * Exact phrase filter for search estimation.
     */
    #[Optional]
    public ?string $exactPhrase;

    /**
     * Words or quoted phrases excluded from estimated results. Separate with spaces, commas, or lines.
     */
    #[Optional]
    public ?string $excludeWords;

    /**
     * Estimate only tweets from this author username (tweet_search_extractor).
     */
    #[Optional]
    public ?string $fromUser;

    /**
     * Hashtags applied to the estimate, separated by spaces, commas, or lines.
     */
    #[Optional]
    public ?string $hashtags;

    /**
     * Estimate only replies to this tweet ID (tweet_search_extractor).
     */
    #[Optional('inReplyToTweetId')]
    public ?string $inReplyToTweetID;

    /**
     * Language code used for estimate filtering (tweet_search_extractor).
     */
    #[Optional]
    public ?string $language;

    /**
     * Estimate search results within this list ID (tweet_search_extractor).
     */
    #[Optional('listId')]
    public ?string $listID;

    /**
     * Media type used for estimate filtering (tweet_search_extractor).
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Estimate tweets mentioning this username (tweet_search_extractor).
     */
    #[Optional]
    public ?string $mentioning;

    /**
     * Minimum likes threshold for estimated results (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minFaves;

    /**
     * Minimum quote count threshold for estimated results (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minQuotes;

    /**
     * Minimum replies threshold for estimated results (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minReplies;

    /**
     * Minimum retweets threshold for estimated results (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minRetweets;

    /**
     * Estimate search results within this place ID (tweet_search_extractor).
     */
    #[Optional]
    public ?string $place;

    /**
     * Estimate search results within this country code (tweet_search_extractor).
     */
    #[Optional]
    public ?string $placeCountry;

    /**
     * Geo point radius used for estimation, e.g. -73.99 40.73 25mi (tweet_search_extractor).
     */
    #[Optional]
    public ?string $pointRadius;

    /**
     * Quote mode used for estimation (tweet_search_extractor).
     *
     * @var value-of<Quotes>|null $quotes
     */
    #[Optional(enum: Quotes::class)]
    public ?string $quotes;

    /**
     * Estimate only quotes of this tweet ID (tweet_search_extractor).
     */
    #[Optional('quotesOfTweetId')]
    public ?string $quotesOfTweetID;

    /**
     * Reply mode used for estimation (tweet_search_extractor).
     *
     * @var value-of<Replies>|null $replies
     */
    #[Optional(enum: Replies::class)]
    public ?string $replies;

    /**
     * Maximum number of results to estimate. When set, the estimate caps projected results to this value.
     */
    #[Optional]
    public ?int $resultsLimit;

    /**
     * Retweet mode used for estimation (tweet_search_extractor).
     *
     * @var value-of<Retweets>|null $retweets
     */
    #[Optional(enum: Retweets::class)]
    public ?string $retweets;

    /**
     * Estimate only retweets of this tweet ID (tweet_search_extractor).
     */
    #[Optional('retweetsOfTweetId')]
    public ?string $retweetsOfTweetID;

    /**
     * Query used to price tweet_search_extractor or community_search.
     */
    #[Optional]
    public ?string $searchQuery;

    /**
     * Estimate start date in YYYY-MM-DD format (tweet_search_extractor).
     */
    #[Optional]
    public ?string $sinceDate;

    /**
     * Community ID used to price community_post_extractor or community_search.
     */
    #[Optional('targetCommunityId')]
    public ?string $targetCommunityID;

    /**
     * List ID used to price list_follower_explorer, list_member_extractor, or list_post_extractor.
     */
    #[Optional('targetListId')]
    public ?string $targetListID;

    /**
     * Space ID used to price space_explorer.
     */
    #[Optional('targetSpaceId')]
    public ?string $targetSpaceID;

    #[Optional('targetTweetId')]
    public ?string $targetTweetID;

    #[Optional]
    public ?string $targetUsername;

    /**
     * Estimate replies sent to this username (tweet_search_extractor).
     */
    #[Optional]
    public ?string $toUser;

    /**
     * Estimate end date in YYYY-MM-DD format (tweet_search_extractor).
     */
    #[Optional]
    public ?string $untilDate;

    /**
     * URL substring or domain filter used for estimation (tweet_search_extractor).
     */
    #[Optional]
    public ?string $url;

    /**
     * Estimate only verified authors (tweet_search_extractor).
     */
    #[Optional]
    public ?bool $verifiedOnly;

    /**
     * `new ExtractionEstimateCostParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionEstimateCostParams::with(toolType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionEstimateCostParams)->withToolType(...)
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
     * @param ToolType|value-of<ToolType> $toolType
     * @param MediaType|value-of<MediaType>|null $mediaType
     * @param Quotes|value-of<Quotes>|null $quotes
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     */
    public static function with(
        ToolType|string $toolType,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $boundingBox = null,
        ?string $cashtags = null,
        ?string $conversationID = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $hashtags = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
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
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        Replies|string|null $replies = null,
        ?int $resultsLimit = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?string $searchQuery = null,
        ?string $sinceDate = null,
        ?string $targetCommunityID = null,
        ?string $targetListID = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?string $targetUsername = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        ?string $url = null,
        ?bool $verifiedOnly = null,
    ): self {
        $self = new self;

        $self['toolType'] = $toolType;

        null !== $advancedQuery && $self['advancedQuery'] = $advancedQuery;
        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $boundingBox && $self['boundingBox'] = $boundingBox;
        null !== $cashtags && $self['cashtags'] = $cashtags;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $fromUser && $self['fromUser'] = $fromUser;
        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $language && $self['language'] = $language;
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
        null !== $quotes && $self['quotes'] = $quotes;
        null !== $quotesOfTweetID && $self['quotesOfTweetID'] = $quotesOfTweetID;
        null !== $replies && $self['replies'] = $replies;
        null !== $resultsLimit && $self['resultsLimit'] = $resultsLimit;
        null !== $retweets && $self['retweets'] = $retweets;
        null !== $retweetsOfTweetID && $self['retweetsOfTweetID'] = $retweetsOfTweetID;
        null !== $searchQuery && $self['searchQuery'] = $searchQuery;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $targetCommunityID && $self['targetCommunityID'] = $targetCommunityID;
        null !== $targetListID && $self['targetListID'] = $targetListID;
        null !== $targetSpaceID && $self['targetSpaceID'] = $targetSpaceID;
        null !== $targetTweetID && $self['targetTweetID'] = $targetTweetID;
        null !== $targetUsername && $self['targetUsername'] = $targetUsername;
        null !== $toUser && $self['toUser'] = $toUser;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $url && $self['url'] = $url;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @param ToolType|value-of<ToolType> $toolType
     */
    public function withToolType(ToolType|string $toolType): self
    {
        $self = clone $this;
        $self['toolType'] = $toolType;

        return $self;
    }

    /**
     * Raw advanced query string appended to the estimate (tweet_search_extractor).
     */
    public function withAdvancedQuery(string $advancedQuery): self
    {
        $self = clone $this;
        $self['advancedQuery'] = $advancedQuery;

        return $self;
    }

    /**
     * Alternative words or quoted phrases for estimated results. Separate with spaces, commas, or lines.
     */
    public function withAnyWords(string $anyWords): self
    {
        $self = clone $this;
        $self['anyWords'] = $anyWords;

        return $self;
    }

    /**
     * Geo bounding box used for estimation, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor).
     */
    public function withBoundingBox(string $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

        return $self;
    }

    /**
     * Cashtags applied to the estimate, separated by spaces, commas, or lines.
     */
    public function withCashtags(string $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * Conversation ID filter used for estimation (tweet_search_extractor).
     */
    public function withConversationID(string $conversationID): self
    {
        $self = clone $this;
        $self['conversationID'] = $conversationID;

        return $self;
    }

    /**
     * Exact phrase filter for search estimation.
     */
    public function withExactPhrase(string $exactPhrase): self
    {
        $self = clone $this;
        $self['exactPhrase'] = $exactPhrase;

        return $self;
    }

    /**
     * Words or quoted phrases excluded from estimated results. Separate with spaces, commas, or lines.
     */
    public function withExcludeWords(string $excludeWords): self
    {
        $self = clone $this;
        $self['excludeWords'] = $excludeWords;

        return $self;
    }

    /**
     * Estimate only tweets from this author username (tweet_search_extractor).
     */
    public function withFromUser(string $fromUser): self
    {
        $self = clone $this;
        $self['fromUser'] = $fromUser;

        return $self;
    }

    /**
     * Hashtags applied to the estimate, separated by spaces, commas, or lines.
     */
    public function withHashtags(string $hashtags): self
    {
        $self = clone $this;
        $self['hashtags'] = $hashtags;

        return $self;
    }

    /**
     * Estimate only replies to this tweet ID (tweet_search_extractor).
     */
    public function withInReplyToTweetID(string $inReplyToTweetID): self
    {
        $self = clone $this;
        $self['inReplyToTweetID'] = $inReplyToTweetID;

        return $self;
    }

    /**
     * Language code used for estimate filtering (tweet_search_extractor).
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Estimate search results within this list ID (tweet_search_extractor).
     */
    public function withListID(string $listID): self
    {
        $self = clone $this;
        $self['listID'] = $listID;

        return $self;
    }

    /**
     * Media type used for estimate filtering (tweet_search_extractor).
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
     * Estimate tweets mentioning this username (tweet_search_extractor).
     */
    public function withMentioning(string $mentioning): self
    {
        $self = clone $this;
        $self['mentioning'] = $mentioning;

        return $self;
    }

    /**
     * Minimum likes threshold for estimated results (tweet_search_extractor).
     */
    public function withMinFaves(int $minFaves): self
    {
        $self = clone $this;
        $self['minFaves'] = $minFaves;

        return $self;
    }

    /**
     * Minimum quote count threshold for estimated results (tweet_search_extractor).
     */
    public function withMinQuotes(int $minQuotes): self
    {
        $self = clone $this;
        $self['minQuotes'] = $minQuotes;

        return $self;
    }

    /**
     * Minimum replies threshold for estimated results (tweet_search_extractor).
     */
    public function withMinReplies(int $minReplies): self
    {
        $self = clone $this;
        $self['minReplies'] = $minReplies;

        return $self;
    }

    /**
     * Minimum retweets threshold for estimated results (tweet_search_extractor).
     */
    public function withMinRetweets(int $minRetweets): self
    {
        $self = clone $this;
        $self['minRetweets'] = $minRetweets;

        return $self;
    }

    /**
     * Estimate search results within this place ID (tweet_search_extractor).
     */
    public function withPlace(string $place): self
    {
        $self = clone $this;
        $self['place'] = $place;

        return $self;
    }

    /**
     * Estimate search results within this country code (tweet_search_extractor).
     */
    public function withPlaceCountry(string $placeCountry): self
    {
        $self = clone $this;
        $self['placeCountry'] = $placeCountry;

        return $self;
    }

    /**
     * Geo point radius used for estimation, e.g. -73.99 40.73 25mi (tweet_search_extractor).
     */
    public function withPointRadius(string $pointRadius): self
    {
        $self = clone $this;
        $self['pointRadius'] = $pointRadius;

        return $self;
    }

    /**
     * Quote mode used for estimation (tweet_search_extractor).
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
     * Estimate only quotes of this tweet ID (tweet_search_extractor).
     */
    public function withQuotesOfTweetID(string $quotesOfTweetID): self
    {
        $self = clone $this;
        $self['quotesOfTweetID'] = $quotesOfTweetID;

        return $self;
    }

    /**
     * Reply mode used for estimation (tweet_search_extractor).
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
     * Maximum number of results to estimate. When set, the estimate caps projected results to this value.
     */
    public function withResultsLimit(int $resultsLimit): self
    {
        $self = clone $this;
        $self['resultsLimit'] = $resultsLimit;

        return $self;
    }

    /**
     * Retweet mode used for estimation (tweet_search_extractor).
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
     * Estimate only retweets of this tweet ID (tweet_search_extractor).
     */
    public function withRetweetsOfTweetID(string $retweetsOfTweetID): self
    {
        $self = clone $this;
        $self['retweetsOfTweetID'] = $retweetsOfTweetID;

        return $self;
    }

    /**
     * Query used to price tweet_search_extractor or community_search.
     */
    public function withSearchQuery(string $searchQuery): self
    {
        $self = clone $this;
        $self['searchQuery'] = $searchQuery;

        return $self;
    }

    /**
     * Estimate start date in YYYY-MM-DD format (tweet_search_extractor).
     */
    public function withSinceDate(string $sinceDate): self
    {
        $self = clone $this;
        $self['sinceDate'] = $sinceDate;

        return $self;
    }

    /**
     * Community ID used to price community_post_extractor or community_search.
     */
    public function withTargetCommunityID(string $targetCommunityID): self
    {
        $self = clone $this;
        $self['targetCommunityID'] = $targetCommunityID;

        return $self;
    }

    /**
     * List ID used to price list_follower_explorer, list_member_extractor, or list_post_extractor.
     */
    public function withTargetListID(string $targetListID): self
    {
        $self = clone $this;
        $self['targetListID'] = $targetListID;

        return $self;
    }

    /**
     * Space ID used to price space_explorer.
     */
    public function withTargetSpaceID(string $targetSpaceID): self
    {
        $self = clone $this;
        $self['targetSpaceID'] = $targetSpaceID;

        return $self;
    }

    public function withTargetTweetID(string $targetTweetID): self
    {
        $self = clone $this;
        $self['targetTweetID'] = $targetTweetID;

        return $self;
    }

    public function withTargetUsername(string $targetUsername): self
    {
        $self = clone $this;
        $self['targetUsername'] = $targetUsername;

        return $self;
    }

    /**
     * Estimate replies sent to this username (tweet_search_extractor).
     */
    public function withToUser(string $toUser): self
    {
        $self = clone $this;
        $self['toUser'] = $toUser;

        return $self;
    }

    /**
     * Estimate end date in YYYY-MM-DD format (tweet_search_extractor).
     */
    public function withUntilDate(string $untilDate): self
    {
        $self = clone $this;
        $self['untilDate'] = $untilDate;

        return $self;
    }

    /**
     * URL substring or domain filter used for estimation (tweet_search_extractor).
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Estimate only verified authors (tweet_search_extractor).
     */
    public function withVerifiedOnly(bool $verifiedOnly): self
    {
        $self = clone $this;
        $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }
}
