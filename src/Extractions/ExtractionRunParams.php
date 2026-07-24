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
use XTwitterScraper\Extractions\ExtractionRunParams\MediaType;
use XTwitterScraper\Extractions\ExtractionRunParams\Quotes;
use XTwitterScraper\Extractions\ExtractionRunParams\Replies;
use XTwitterScraper\Extractions\ExtractionRunParams\Retweets;
use XTwitterScraper\Extractions\ExtractionRunParams\ToolType;

/**
 * Run extraction.
 *
 * @see XTwitterScraper\Services\ExtractionsService::run()
 *
 * @phpstan-type ExtractionRunParamsShape = array{
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
final class ExtractionRunParams implements BaseModel
{
    /** @use SdkModel<ExtractionRunParamsShape> */
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
     * Raw advanced search query appended as-is (tweet_search_extractor).
     */
    #[Optional]
    public ?string $advancedQuery;

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines. (tweet_search_extractor).
     */
    #[Optional]
    public ?string $anyWords;

    /**
     * Geo bounding box, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor).
     */
    #[Optional]
    public ?string $boundingBox;

    /**
     * Cashtags separated by spaces, commas, or lines. (tweet_search_extractor).
     */
    #[Optional]
    public ?string $cashtags;

    /**
     * Conversation ID filter (tweet_search_extractor).
     */
    #[Optional('conversationId')]
    public ?string $conversationID;

    /**
     * Exact phrase to match (tweet_search_extractor).
     */
    #[Optional]
    public ?string $exactPhrase;

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines. (tweet_search_extractor).
     */
    #[Optional]
    public ?string $excludeWords;

    /**
     * Filter by author username (tweet_search_extractor).
     */
    #[Optional]
    public ?string $fromUser;

    /**
     * Hashtags separated by spaces, commas, or lines. (tweet_search_extractor).
     */
    #[Optional]
    public ?string $hashtags;

    /**
     * Only replies to this tweet ID (tweet_search_extractor).
     */
    #[Optional('inReplyToTweetId')]
    public ?string $inReplyToTweetID;

    /**
     * Language code filter (tweet_search_extractor).
     */
    #[Optional]
    public ?string $language;

    /**
     * Search within a list ID (tweet_search_extractor).
     */
    #[Optional('listId')]
    public ?string $listID;

    /**
     * Media type filter (tweet_search_extractor).
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Filter tweets mentioning a username (tweet_search_extractor).
     */
    #[Optional]
    public ?string $mentioning;

    /**
     * Minimum likes threshold (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minFaves;

    /**
     * Minimum quote count threshold (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minQuotes;

    /**
     * Minimum replies threshold (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minReplies;

    /**
     * Minimum retweets threshold (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minRetweets;

    /**
     * Search within a place ID (tweet_search_extractor).
     */
    #[Optional]
    public ?string $place;

    /**
     * Search within a country code (tweet_search_extractor).
     */
    #[Optional]
    public ?string $placeCountry;

    /**
     * Geo point radius, e.g. -73.99 40.73 25mi (tweet_search_extractor).
     */
    #[Optional]
    public ?string $pointRadius;

    /**
     * Quote mode (tweet_search_extractor).
     *
     * @var value-of<Quotes>|null $quotes
     */
    #[Optional(enum: Quotes::class)]
    public ?string $quotes;

    /**
     * Only quotes of this tweet ID (tweet_search_extractor).
     */
    #[Optional('quotesOfTweetId')]
    public ?string $quotesOfTweetID;

    /**
     * Reply mode (tweet_search_extractor).
     *
     * @var value-of<Replies>|null $replies
     */
    #[Optional(enum: Replies::class)]
    public ?string $replies;

    /**
     * Maximum number of results to extract. When set, the extraction stops after reaching this limit.
     */
    #[Optional]
    public ?int $resultsLimit;

    /**
     * Retweet mode (tweet_search_extractor).
     *
     * @var value-of<Retweets>|null $retweets
     */
    #[Optional(enum: Retweets::class)]
    public ?string $retweets;

    /**
     * Only retweets of this tweet ID (tweet_search_extractor).
     */
    #[Optional('retweetsOfTweetId')]
    public ?string $retweetsOfTweetID;

    /**
     * Required for tweet_search_extractor & community_search.
     */
    #[Optional]
    public ?string $searchQuery;

    /**
     * Start date YYYY-MM-DD (tweet_search_extractor).
     */
    #[Optional]
    public ?string $sinceDate;

    /**
     * Required for community_post_extractor & community_search.
     */
    #[Optional('targetCommunityId')]
    public ?string $targetCommunityID;

    /**
     * Required for list_follower_explorer, list_member_extractor & list_post_extractor.
     */
    #[Optional('targetListId')]
    public ?string $targetListID;

    /**
     * Required for space_explorer.
     */
    #[Optional('targetSpaceId')]
    public ?string $targetSpaceID;

    #[Optional('targetTweetId')]
    public ?string $targetTweetID;

    #[Optional]
    public ?string $targetUsername;

    /**
     * Filter replies sent to a username (tweet_search_extractor).
     */
    #[Optional]
    public ?string $toUser;

    /**
     * End date YYYY-MM-DD (tweet_search_extractor).
     */
    #[Optional]
    public ?string $untilDate;

    /**
     * URL substring or domain filter (tweet_search_extractor).
     */
    #[Optional]
    public ?string $url;

    /**
     * Only verified authors (tweet_search_extractor).
     */
    #[Optional]
    public ?bool $verifiedOnly;

    /**
     * `new ExtractionRunParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionRunParams::with(toolType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionRunParams)->withToolType(...)
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
     * Raw advanced search query appended as-is (tweet_search_extractor).
     */
    public function withAdvancedQuery(string $advancedQuery): self
    {
        $self = clone $this;
        $self['advancedQuery'] = $advancedQuery;

        return $self;
    }

    /**
     * Words or quoted phrases where any one can match. Separate with spaces, commas, or lines. (tweet_search_extractor).
     */
    public function withAnyWords(string $anyWords): self
    {
        $self = clone $this;
        $self['anyWords'] = $anyWords;

        return $self;
    }

    /**
     * Geo bounding box, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor).
     */
    public function withBoundingBox(string $boundingBox): self
    {
        $self = clone $this;
        $self['boundingBox'] = $boundingBox;

        return $self;
    }

    /**
     * Cashtags separated by spaces, commas, or lines. (tweet_search_extractor).
     */
    public function withCashtags(string $cashtags): self
    {
        $self = clone $this;
        $self['cashtags'] = $cashtags;

        return $self;
    }

    /**
     * Conversation ID filter (tweet_search_extractor).
     */
    public function withConversationID(string $conversationID): self
    {
        $self = clone $this;
        $self['conversationID'] = $conversationID;

        return $self;
    }

    /**
     * Exact phrase to match (tweet_search_extractor).
     */
    public function withExactPhrase(string $exactPhrase): self
    {
        $self = clone $this;
        $self['exactPhrase'] = $exactPhrase;

        return $self;
    }

    /**
     * Words or quoted phrases to exclude. Separate with spaces, commas, or lines. (tweet_search_extractor).
     */
    public function withExcludeWords(string $excludeWords): self
    {
        $self = clone $this;
        $self['excludeWords'] = $excludeWords;

        return $self;
    }

    /**
     * Filter by author username (tweet_search_extractor).
     */
    public function withFromUser(string $fromUser): self
    {
        $self = clone $this;
        $self['fromUser'] = $fromUser;

        return $self;
    }

    /**
     * Hashtags separated by spaces, commas, or lines. (tweet_search_extractor).
     */
    public function withHashtags(string $hashtags): self
    {
        $self = clone $this;
        $self['hashtags'] = $hashtags;

        return $self;
    }

    /**
     * Only replies to this tweet ID (tweet_search_extractor).
     */
    public function withInReplyToTweetID(string $inReplyToTweetID): self
    {
        $self = clone $this;
        $self['inReplyToTweetID'] = $inReplyToTweetID;

        return $self;
    }

    /**
     * Language code filter (tweet_search_extractor).
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Search within a list ID (tweet_search_extractor).
     */
    public function withListID(string $listID): self
    {
        $self = clone $this;
        $self['listID'] = $listID;

        return $self;
    }

    /**
     * Media type filter (tweet_search_extractor).
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
     * Filter tweets mentioning a username (tweet_search_extractor).
     */
    public function withMentioning(string $mentioning): self
    {
        $self = clone $this;
        $self['mentioning'] = $mentioning;

        return $self;
    }

    /**
     * Minimum likes threshold (tweet_search_extractor).
     */
    public function withMinFaves(int $minFaves): self
    {
        $self = clone $this;
        $self['minFaves'] = $minFaves;

        return $self;
    }

    /**
     * Minimum quote count threshold (tweet_search_extractor).
     */
    public function withMinQuotes(int $minQuotes): self
    {
        $self = clone $this;
        $self['minQuotes'] = $minQuotes;

        return $self;
    }

    /**
     * Minimum replies threshold (tweet_search_extractor).
     */
    public function withMinReplies(int $minReplies): self
    {
        $self = clone $this;
        $self['minReplies'] = $minReplies;

        return $self;
    }

    /**
     * Minimum retweets threshold (tweet_search_extractor).
     */
    public function withMinRetweets(int $minRetweets): self
    {
        $self = clone $this;
        $self['minRetweets'] = $minRetweets;

        return $self;
    }

    /**
     * Search within a place ID (tweet_search_extractor).
     */
    public function withPlace(string $place): self
    {
        $self = clone $this;
        $self['place'] = $place;

        return $self;
    }

    /**
     * Search within a country code (tweet_search_extractor).
     */
    public function withPlaceCountry(string $placeCountry): self
    {
        $self = clone $this;
        $self['placeCountry'] = $placeCountry;

        return $self;
    }

    /**
     * Geo point radius, e.g. -73.99 40.73 25mi (tweet_search_extractor).
     */
    public function withPointRadius(string $pointRadius): self
    {
        $self = clone $this;
        $self['pointRadius'] = $pointRadius;

        return $self;
    }

    /**
     * Quote mode (tweet_search_extractor).
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
     * Only quotes of this tweet ID (tweet_search_extractor).
     */
    public function withQuotesOfTweetID(string $quotesOfTweetID): self
    {
        $self = clone $this;
        $self['quotesOfTweetID'] = $quotesOfTweetID;

        return $self;
    }

    /**
     * Reply mode (tweet_search_extractor).
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
     * Maximum number of results to extract. When set, the extraction stops after reaching this limit.
     */
    public function withResultsLimit(int $resultsLimit): self
    {
        $self = clone $this;
        $self['resultsLimit'] = $resultsLimit;

        return $self;
    }

    /**
     * Retweet mode (tweet_search_extractor).
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
     * Only retweets of this tweet ID (tweet_search_extractor).
     */
    public function withRetweetsOfTweetID(string $retweetsOfTweetID): self
    {
        $self = clone $this;
        $self['retweetsOfTweetID'] = $retweetsOfTweetID;

        return $self;
    }

    /**
     * Required for tweet_search_extractor & community_search.
     */
    public function withSearchQuery(string $searchQuery): self
    {
        $self = clone $this;
        $self['searchQuery'] = $searchQuery;

        return $self;
    }

    /**
     * Start date YYYY-MM-DD (tweet_search_extractor).
     */
    public function withSinceDate(string $sinceDate): self
    {
        $self = clone $this;
        $self['sinceDate'] = $sinceDate;

        return $self;
    }

    /**
     * Required for community_post_extractor & community_search.
     */
    public function withTargetCommunityID(string $targetCommunityID): self
    {
        $self = clone $this;
        $self['targetCommunityID'] = $targetCommunityID;

        return $self;
    }

    /**
     * Required for list_follower_explorer, list_member_extractor & list_post_extractor.
     */
    public function withTargetListID(string $targetListID): self
    {
        $self = clone $this;
        $self['targetListID'] = $targetListID;

        return $self;
    }

    /**
     * Required for space_explorer.
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
     * Filter replies sent to a username (tweet_search_extractor).
     */
    public function withToUser(string $toUser): self
    {
        $self = clone $this;
        $self['toUser'] = $toUser;

        return $self;
    }

    /**
     * End date YYYY-MM-DD (tweet_search_extractor).
     */
    public function withUntilDate(string $untilDate): self
    {
        $self = clone $this;
        $self['untilDate'] = $untilDate;

        return $self;
    }

    /**
     * URL substring or domain filter (tweet_search_extractor).
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Only verified authors (tweet_search_extractor).
     */
    public function withVerifiedOnly(bool $verifiedOnly): self
    {
        $self = clone $this;
        $self['verifiedOnly'] = $verifiedOnly;

        return $self;
    }
}
