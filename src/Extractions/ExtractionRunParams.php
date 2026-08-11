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
use XTwitterScraper\Extractions\ExtractionRunParams\CollectionStrategy;
use XTwitterScraper\Extractions\ExtractionRunParams\DedupeMode;
use XTwitterScraper\Extractions\ExtractionRunParams\MediaType;
use XTwitterScraper\Extractions\ExtractionRunParams\QueryType;
use XTwitterScraper\Extractions\ExtractionRunParams\Quotes;
use XTwitterScraper\Extractions\ExtractionRunParams\RelationTarget;
use XTwitterScraper\Extractions\ExtractionRunParams\Replies;
use XTwitterScraper\Extractions\ExtractionRunParams\Retweets;
use XTwitterScraper\Extractions\ExtractionRunParams\Scope;
use XTwitterScraper\Extractions\ExtractionRunParams\Sort;
use XTwitterScraper\Extractions\ExtractionRunParams\Target;
use XTwitterScraper\Extractions\ExtractionRunParams\ToolType;

/**
 * Run extraction.
 *
 * @see XTwitterScraper\Services\ExtractionsService::run()
 *
 * @phpstan-import-type SinceTimeVariants from \XTwitterScraper\Extractions\ExtractionRunParams\SinceTime
 * @phpstan-import-type TargetVariants from \XTwitterScraper\Extractions\ExtractionRunParams\Target
 * @phpstan-import-type UntilTimeVariants from \XTwitterScraper\Extractions\ExtractionRunParams\UntilTime
 * @phpstan-import-type RelationTargetShape from \XTwitterScraper\Extractions\ExtractionRunParams\RelationTarget
 * @phpstan-import-type SinceTimeShape from \XTwitterScraper\Extractions\ExtractionRunParams\SinceTime
 * @phpstan-import-type TargetShape from \XTwitterScraper\Extractions\ExtractionRunParams\Target
 * @phpstan-import-type UntilTimeShape from \XTwitterScraper\Extractions\ExtractionRunParams\UntilTime
 *
 * @phpstan-type ExtractionRunParamsShape = array{
 *   toolType: ToolType|value-of<ToolType>,
 *   dryRun?: bool|null,
 *   advancedQuery?: string|null,
 *   anyWords?: string|null,
 *   bioContains?: string|null,
 *   blueVerifiedOnly?: bool|null,
 *   boundingBox?: string|null,
 *   cardName?: string|null,
 *   cashtags?: string|null,
 *   collectionStrategy?: null|CollectionStrategy|value-of<CollectionStrategy>,
 *   conversationID?: string|null,
 *   dedupeAcrossTargets?: bool|null,
 *   dedupeMode?: null|DedupeMode|value-of<DedupeMode>,
 *   exactPhrase?: string|null,
 *   excludeOriginalAuthor?: bool|null,
 *   excludeSource?: string|null,
 *   excludeWords?: string|null,
 *   fromUser?: string|null,
 *   geocode?: string|null,
 *   hashtags?: string|null,
 *   hasLocation?: bool|null,
 *   hasMediaOnly?: bool|null,
 *   hasWebsite?: bool|null,
 *   includeOriginalPost?: bool|null,
 *   includeSearchTerms?: bool|null,
 *   includeTargetMetadata?: bool|null,
 *   inReplyToTweetID?: string|null,
 *   language?: string|null,
 *   listID?: string|null,
 *   locationContains?: string|null,
 *   maxDepth?: int|null,
 *   maxFollowers?: int|null,
 *   maxFollowing?: int|null,
 *   maxID?: string|null,
 *   maxItemsPerTarget?: int|null,
 *   maxLikes?: int|null,
 *   maxPagesPerTarget?: int|null,
 *   maxPosts?: int|null,
 *   maxQuotes?: int|null,
 *   maxReplies?: int|null,
 *   maxRetweets?: int|null,
 *   mediaType?: null|MediaType|value-of<MediaType>,
 *   mentioning?: string|null,
 *   minAccountAgeDays?: int|null,
 *   minBookmarks?: int|null,
 *   minFaves?: int|null,
 *   minFollowers?: int|null,
 *   minFollowing?: int|null,
 *   minPosts?: int|null,
 *   minQuotes?: int|null,
 *   minReplies?: int|null,
 *   minRetweets?: int|null,
 *   minViews?: int|null,
 *   nativeRetweets?: bool|null,
 *   near?: string|null,
 *   news?: bool|null,
 *   overlapMode?: bool|null,
 *   place?: string|null,
 *   placeCountry?: string|null,
 *   pointRadius?: string|null,
 *   queryType?: null|QueryType|value-of<QueryType>,
 *   quotes?: null|Quotes|value-of<Quotes>,
 *   quotesOfTweetID?: string|null,
 *   relationTargets?: list<RelationTarget|RelationTargetShape>|null,
 *   replies?: null|Replies|value-of<Replies>,
 *   resultsLimit?: int|null,
 *   retweets?: null|Retweets|value-of<Retweets>,
 *   retweetsOfTweetID?: string|null,
 *   safe?: bool|null,
 *   scope?: null|Scope|value-of<Scope>,
 *   searchQueries?: list<string>|null,
 *   searchQuery?: string|null,
 *   sinceDate?: string|null,
 *   sinceID?: string|null,
 *   sinceTime?: SinceTimeShape|null,
 *   sort?: null|Sort|value-of<Sort>,
 *   source?: string|null,
 *   startCursor?: string|null,
 *   targetCommunityID?: string|null,
 *   targetCommunityIDs?: list<string>|null,
 *   targetListID?: string|null,
 *   targetListIDs?: list<string>|null,
 *   targets?: list<TargetShape>|null,
 *   targetSpaceID?: string|null,
 *   targetTweetID?: string|null,
 *   targetTweetIDs?: list<string>|null,
 *   targetUsername?: string|null,
 *   targetUsernames?: list<string>|null,
 *   toUser?: string|null,
 *   untilDate?: string|null,
 *   untilTime?: UntilTimeShape|null,
 *   url?: string|null,
 *   usernameContains?: string|null,
 *   verifiedOnly?: bool|null,
 *   verifiedType?: string|null,
 *   within?: string|null,
 *   withinTime?: string|null,
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
     * Estimate cost without creating an extraction.
     */
    #[Optional]
    public ?bool $dryRun;

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
     * Bio terms separated by commas or lines.
     */
    #[Optional]
    public ?string $bioContains;

    /**
     * Return only Blue-verified Tweet authors.
     */
    #[Optional]
    public ?bool $blueVerifiedOnly;

    /**
     * Geo bounding box, e.g. -74.1 40.6 -73.9 40.8 (tweet_search_extractor).
     */
    #[Optional]
    public ?string $boundingBox;

    /**
     * Match the Tweet card name.
     */
    #[Optional]
    public ?string $cardName;

    /**
     * Cashtags separated by spaces, commas, or lines. (tweet_search_extractor).
     */
    #[Optional]
    public ?string $cashtags;

    /**
     * Reply collection strategy.
     *
     * @var value-of<CollectionStrategy>|null $collectionStrategy
     */
    #[Optional(enum: CollectionStrategy::class)]
    public ?string $collectionStrategy;

    /**
     * Conversation ID filter (tweet_search_extractor).
     */
    #[Optional('conversationId')]
    public ?string $conversationID;

    /**
     * Merge duplicate results across collection targets.
     */
    #[Optional]
    public ?bool $dedupeAcrossTargets;

    /**
     * Keep target duplicates, first rows, or merged overlap.
     *
     * @var value-of<DedupeMode>|null $dedupeMode
     */
    #[Optional(enum: DedupeMode::class)]
    public ?string $dedupeMode;

    /**
     * Exact phrase to match (tweet_search_extractor).
     */
    #[Optional]
    public ?string $exactPhrase;

    /**
     * Exclude replies from the source author.
     */
    #[Optional]
    public ?bool $excludeOriginalAuthor;

    /**
     * Exclude a source application.
     */
    #[Optional]
    public ?string $excludeSource;

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
     * Match latitude, longitude, and radius.
     */
    #[Optional]
    public ?string $geocode;

    /**
     * Hashtags separated by spaces, commas, or lines. (tweet_search_extractor).
     */
    #[Optional]
    public ?string $hashtags;

    /**
     * Require a profile location.
     */
    #[Optional]
    public ?bool $hasLocation;

    /**
     * Return only replies with media.
     */
    #[Optional]
    public ?bool $hasMediaOnly;

    /**
     * Require a profile website.
     */
    #[Optional]
    public ?bool $hasWebsite;

    /**
     * Include the source post in reply results.
     */
    #[Optional]
    public ?bool $includeOriginalPost;

    /**
     * Add matching search terms to collection metadata.
     */
    #[Optional]
    public ?bool $includeSearchTerms;

    /**
     * Add source target metadata to each result.
     */
    #[Optional]
    public ?bool $includeTargetMetadata;

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
     * Required profile location text.
     */
    #[Optional]
    public ?string $locationContains;

    /**
     * Maximum nested reply depth.
     */
    #[Optional]
    public ?int $maxDepth;

    /**
     * Maximum follower count for profile results.
     */
    #[Optional]
    public ?int $maxFollowers;

    /**
     * Maximum following count for profile results.
     */
    #[Optional]
    public ?int $maxFollowing;

    /**
     * Return Tweets older than this Tweet ID.
     */
    #[Optional('maxId')]
    public ?string $maxID;

    /**
     * Maximum results collected for each target.
     */
    #[Optional]
    public ?int $maxItemsPerTarget;

    /**
     * Maximum Tweet like count.
     */
    #[Optional]
    public ?int $maxLikes;

    /**
     * Reply pages collected for each target.
     */
    #[Optional]
    public ?int $maxPagesPerTarget;

    /**
     * Maximum post count for profile results.
     */
    #[Optional]
    public ?int $maxPosts;

    /**
     * Maximum Tweet quote count.
     */
    #[Optional]
    public ?int $maxQuotes;

    /**
     * Maximum Tweet reply count.
     */
    #[Optional]
    public ?int $maxReplies;

    /**
     * Maximum Tweet repost count.
     */
    #[Optional]
    public ?int $maxRetweets;

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
     * Minimum profile age in days.
     */
    #[Optional]
    public ?int $minAccountAgeDays;

    /**
     * Minimum Tweet bookmark count.
     */
    #[Optional]
    public ?int $minBookmarks;

    /**
     * Minimum likes threshold (tweet_search_extractor).
     */
    #[Optional]
    public ?int $minFaves;

    /**
     * Minimum follower count for profile results.
     */
    #[Optional]
    public ?int $minFollowers;

    /**
     * Minimum following count for profile results.
     */
    #[Optional]
    public ?int $minFollowing;

    /**
     * Minimum post count for profile results.
     */
    #[Optional]
    public ?int $minPosts;

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
     * Minimum Tweet view count.
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
     * Shortcut for dedupeMode=merge.
     */
    #[Optional]
    public ?bool $overlapMode;

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
     * Search ranking applied to every query.
     *
     * @var value-of<QueryType>|null $queryType
     */
    #[Optional(enum: QueryType::class)]
    public ?string $queryType;

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
     * Profile relations processed within one job.
     *
     * @var list<RelationTarget>|null $relationTargets
     */
    #[Optional(list: RelationTarget::class)]
    public ?array $relationTargets;

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
     * Enable the safe-search filter.
     */
    #[Optional]
    public ?bool $safe;

    /**
     * Reply depth scope.
     *
     * @var value-of<Scope>|null $scope
     */
    #[Optional(enum: Scope::class)]
    public ?string $scope;

    /**
     * Search queries processed as one collection job.
     *
     * @var list<string>|null $searchQueries
     */
    #[Optional(list: 'string')]
    public ?array $searchQueries;

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
     * Return Tweets newer than this Tweet ID.
     */
    #[Optional('sinceId')]
    public ?string $sinceID;

    /**
     * Reply start time as ISO 8601 or Unix seconds.
     *
     * @var SinceTimeVariants|null $sinceTime
     */
    #[Optional]
    public int|\DateTimeInterface|null $sinceTime;

    /**
     * Reply result order.
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
     * Resume one reply target from this cursor.
     */
    #[Optional]
    public ?string $startCursor;

    /**
     * Required for community_post_extractor & community_search.
     */
    #[Optional('targetCommunityId')]
    public ?string $targetCommunityID;

    /**
     * Community IDs processed as one collection job.
     *
     * @var list<string>|null $targetCommunityIDs
     */
    #[Optional('targetCommunityIds', list: 'string')]
    public ?array $targetCommunityIDs;

    /**
     * Required for list_follower_explorer, list_member_extractor & list_post_extractor.
     */
    #[Optional('targetListId')]
    public ?string $targetListID;

    /**
     * List IDs processed as one collection job.
     *
     * @var list<string>|null $targetListIDs
     */
    #[Optional('targetListIds', list: 'string')]
    public ?array $targetListIDs;

    /**
     * Mixed targets auto-routed within one job.
     *
     * @var list<TargetVariants>|null $targets
     */
    #[Optional(list: Target::class)]
    public ?array $targets;

    /**
     * Required for space_explorer.
     */
    #[Optional('targetSpaceId')]
    public ?string $targetSpaceID;

    #[Optional('targetTweetId')]
    public ?string $targetTweetID;

    /**
     * Tweet IDs processed as one collection job.
     *
     * @var list<string>|null $targetTweetIDs
     */
    #[Optional('targetTweetIds', list: 'string')]
    public ?array $targetTweetIDs;

    #[Optional]
    public ?string $targetUsername;

    /**
     * Usernames processed as one collection job.
     *
     * @var list<string>|null $targetUsernames
     */
    #[Optional(list: 'string')]
    public ?array $targetUsernames;

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
     * Reply end time as ISO 8601 or Unix seconds.
     *
     * @var UntilTimeVariants|null $untilTime
     */
    #[Optional]
    public int|\DateTimeInterface|null $untilTime;

    /**
     * URL substring or domain filter (tweet_search_extractor).
     */
    #[Optional]
    public ?string $url;

    /**
     * Required username text.
     */
    #[Optional]
    public ?string $usernameContains;

    /**
     * Only verified authors (tweet_search_extractor).
     */
    #[Optional]
    public ?bool $verifiedOnly;

    /**
     * Exact profile verification type.
     */
    #[Optional]
    public ?string $verifiedType;

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
     * @param CollectionStrategy|value-of<CollectionStrategy>|null $collectionStrategy
     * @param DedupeMode|value-of<DedupeMode>|null $dedupeMode
     * @param MediaType|value-of<MediaType>|null $mediaType
     * @param QueryType|value-of<QueryType>|null $queryType
     * @param Quotes|value-of<Quotes>|null $quotes
     * @param list<RelationTarget|RelationTargetShape>|null $relationTargets
     * @param Replies|value-of<Replies>|null $replies
     * @param Retweets|value-of<Retweets>|null $retweets
     * @param Scope|value-of<Scope>|null $scope
     * @param list<string>|null $searchQueries
     * @param SinceTimeShape|null $sinceTime
     * @param Sort|value-of<Sort>|null $sort
     * @param list<string>|null $targetCommunityIDs
     * @param list<string>|null $targetListIDs
     * @param list<TargetShape>|null $targets
     * @param list<string>|null $targetTweetIDs
     * @param list<string>|null $targetUsernames
     * @param UntilTimeShape|null $untilTime
     */
    public static function with(
        ToolType|string $toolType,
        ?bool $dryRun = null,
        ?string $advancedQuery = null,
        ?string $anyWords = null,
        ?string $bioContains = null,
        ?bool $blueVerifiedOnly = null,
        ?string $boundingBox = null,
        ?string $cardName = null,
        ?string $cashtags = null,
        CollectionStrategy|string|null $collectionStrategy = null,
        ?string $conversationID = null,
        ?bool $dedupeAcrossTargets = null,
        DedupeMode|string|null $dedupeMode = null,
        ?string $exactPhrase = null,
        ?bool $excludeOriginalAuthor = null,
        ?string $excludeSource = null,
        ?string $excludeWords = null,
        ?string $fromUser = null,
        ?string $geocode = null,
        ?string $hashtags = null,
        ?bool $hasLocation = null,
        ?bool $hasMediaOnly = null,
        ?bool $hasWebsite = null,
        ?bool $includeOriginalPost = null,
        ?bool $includeSearchTerms = null,
        ?bool $includeTargetMetadata = null,
        ?string $inReplyToTweetID = null,
        ?string $language = null,
        ?string $listID = null,
        ?string $locationContains = null,
        ?int $maxDepth = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?string $maxID = null,
        ?int $maxItemsPerTarget = null,
        ?int $maxLikes = null,
        ?int $maxPagesPerTarget = null,
        ?int $maxPosts = null,
        ?int $maxQuotes = null,
        ?int $maxReplies = null,
        ?int $maxRetweets = null,
        MediaType|string|null $mediaType = null,
        ?string $mentioning = null,
        ?int $minAccountAgeDays = null,
        ?int $minBookmarks = null,
        ?int $minFaves = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minPosts = null,
        ?int $minQuotes = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?bool $nativeRetweets = null,
        ?string $near = null,
        ?bool $news = null,
        ?bool $overlapMode = null,
        ?string $place = null,
        ?string $placeCountry = null,
        ?string $pointRadius = null,
        QueryType|string|null $queryType = null,
        Quotes|string|null $quotes = null,
        ?string $quotesOfTweetID = null,
        ?array $relationTargets = null,
        Replies|string|null $replies = null,
        ?int $resultsLimit = null,
        Retweets|string|null $retweets = null,
        ?string $retweetsOfTweetID = null,
        ?bool $safe = null,
        Scope|string|null $scope = null,
        ?array $searchQueries = null,
        ?string $searchQuery = null,
        ?string $sinceDate = null,
        ?string $sinceID = null,
        int|\DateTimeInterface|null $sinceTime = null,
        Sort|string|null $sort = null,
        ?string $source = null,
        ?string $startCursor = null,
        ?string $targetCommunityID = null,
        ?array $targetCommunityIDs = null,
        ?string $targetListID = null,
        ?array $targetListIDs = null,
        ?array $targets = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?array $targetTweetIDs = null,
        ?string $targetUsername = null,
        ?array $targetUsernames = null,
        ?string $toUser = null,
        ?string $untilDate = null,
        int|\DateTimeInterface|null $untilTime = null,
        ?string $url = null,
        ?string $usernameContains = null,
        ?bool $verifiedOnly = null,
        ?string $verifiedType = null,
        ?string $within = null,
        ?string $withinTime = null,
    ): self {
        $self = new self;

        $self['toolType'] = $toolType;

        null !== $dryRun && $self['dryRun'] = $dryRun;
        null !== $advancedQuery && $self['advancedQuery'] = $advancedQuery;
        null !== $anyWords && $self['anyWords'] = $anyWords;
        null !== $bioContains && $self['bioContains'] = $bioContains;
        null !== $blueVerifiedOnly && $self['blueVerifiedOnly'] = $blueVerifiedOnly;
        null !== $boundingBox && $self['boundingBox'] = $boundingBox;
        null !== $cardName && $self['cardName'] = $cardName;
        null !== $cashtags && $self['cashtags'] = $cashtags;
        null !== $collectionStrategy && $self['collectionStrategy'] = $collectionStrategy;
        null !== $conversationID && $self['conversationID'] = $conversationID;
        null !== $dedupeAcrossTargets && $self['dedupeAcrossTargets'] = $dedupeAcrossTargets;
        null !== $dedupeMode && $self['dedupeMode'] = $dedupeMode;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeOriginalAuthor && $self['excludeOriginalAuthor'] = $excludeOriginalAuthor;
        null !== $excludeSource && $self['excludeSource'] = $excludeSource;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $fromUser && $self['fromUser'] = $fromUser;
        null !== $geocode && $self['geocode'] = $geocode;
        null !== $hashtags && $self['hashtags'] = $hashtags;
        null !== $hasLocation && $self['hasLocation'] = $hasLocation;
        null !== $hasMediaOnly && $self['hasMediaOnly'] = $hasMediaOnly;
        null !== $hasWebsite && $self['hasWebsite'] = $hasWebsite;
        null !== $includeOriginalPost && $self['includeOriginalPost'] = $includeOriginalPost;
        null !== $includeSearchTerms && $self['includeSearchTerms'] = $includeSearchTerms;
        null !== $includeTargetMetadata && $self['includeTargetMetadata'] = $includeTargetMetadata;
        null !== $inReplyToTweetID && $self['inReplyToTweetID'] = $inReplyToTweetID;
        null !== $language && $self['language'] = $language;
        null !== $listID && $self['listID'] = $listID;
        null !== $locationContains && $self['locationContains'] = $locationContains;
        null !== $maxDepth && $self['maxDepth'] = $maxDepth;
        null !== $maxFollowers && $self['maxFollowers'] = $maxFollowers;
        null !== $maxFollowing && $self['maxFollowing'] = $maxFollowing;
        null !== $maxID && $self['maxID'] = $maxID;
        null !== $maxItemsPerTarget && $self['maxItemsPerTarget'] = $maxItemsPerTarget;
        null !== $maxLikes && $self['maxLikes'] = $maxLikes;
        null !== $maxPagesPerTarget && $self['maxPagesPerTarget'] = $maxPagesPerTarget;
        null !== $maxPosts && $self['maxPosts'] = $maxPosts;
        null !== $maxQuotes && $self['maxQuotes'] = $maxQuotes;
        null !== $maxReplies && $self['maxReplies'] = $maxReplies;
        null !== $maxRetweets && $self['maxRetweets'] = $maxRetweets;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $mentioning && $self['mentioning'] = $mentioning;
        null !== $minAccountAgeDays && $self['minAccountAgeDays'] = $minAccountAgeDays;
        null !== $minBookmarks && $self['minBookmarks'] = $minBookmarks;
        null !== $minFaves && $self['minFaves'] = $minFaves;
        null !== $minFollowers && $self['minFollowers'] = $minFollowers;
        null !== $minFollowing && $self['minFollowing'] = $minFollowing;
        null !== $minPosts && $self['minPosts'] = $minPosts;
        null !== $minQuotes && $self['minQuotes'] = $minQuotes;
        null !== $minReplies && $self['minReplies'] = $minReplies;
        null !== $minRetweets && $self['minRetweets'] = $minRetweets;
        null !== $minViews && $self['minViews'] = $minViews;
        null !== $nativeRetweets && $self['nativeRetweets'] = $nativeRetweets;
        null !== $near && $self['near'] = $near;
        null !== $news && $self['news'] = $news;
        null !== $overlapMode && $self['overlapMode'] = $overlapMode;
        null !== $place && $self['place'] = $place;
        null !== $placeCountry && $self['placeCountry'] = $placeCountry;
        null !== $pointRadius && $self['pointRadius'] = $pointRadius;
        null !== $queryType && $self['queryType'] = $queryType;
        null !== $quotes && $self['quotes'] = $quotes;
        null !== $quotesOfTweetID && $self['quotesOfTweetID'] = $quotesOfTweetID;
        null !== $relationTargets && $self['relationTargets'] = $relationTargets;
        null !== $replies && $self['replies'] = $replies;
        null !== $resultsLimit && $self['resultsLimit'] = $resultsLimit;
        null !== $retweets && $self['retweets'] = $retweets;
        null !== $retweetsOfTweetID && $self['retweetsOfTweetID'] = $retweetsOfTweetID;
        null !== $safe && $self['safe'] = $safe;
        null !== $scope && $self['scope'] = $scope;
        null !== $searchQueries && $self['searchQueries'] = $searchQueries;
        null !== $searchQuery && $self['searchQuery'] = $searchQuery;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $sinceID && $self['sinceID'] = $sinceID;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $sort && $self['sort'] = $sort;
        null !== $source && $self['source'] = $source;
        null !== $startCursor && $self['startCursor'] = $startCursor;
        null !== $targetCommunityID && $self['targetCommunityID'] = $targetCommunityID;
        null !== $targetCommunityIDs && $self['targetCommunityIDs'] = $targetCommunityIDs;
        null !== $targetListID && $self['targetListID'] = $targetListID;
        null !== $targetListIDs && $self['targetListIDs'] = $targetListIDs;
        null !== $targets && $self['targets'] = $targets;
        null !== $targetSpaceID && $self['targetSpaceID'] = $targetSpaceID;
        null !== $targetTweetID && $self['targetTweetID'] = $targetTweetID;
        null !== $targetTweetIDs && $self['targetTweetIDs'] = $targetTweetIDs;
        null !== $targetUsername && $self['targetUsername'] = $targetUsername;
        null !== $targetUsernames && $self['targetUsernames'] = $targetUsernames;
        null !== $toUser && $self['toUser'] = $toUser;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $untilTime && $self['untilTime'] = $untilTime;
        null !== $url && $self['url'] = $url;
        null !== $usernameContains && $self['usernameContains'] = $usernameContains;
        null !== $verifiedOnly && $self['verifiedOnly'] = $verifiedOnly;
        null !== $verifiedType && $self['verifiedType'] = $verifiedType;
        null !== $within && $self['within'] = $within;
        null !== $withinTime && $self['withinTime'] = $withinTime;

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
     * Estimate cost without creating an extraction.
     */
    public function withDryRun(bool $dryRun): self
    {
        $self = clone $this;
        $self['dryRun'] = $dryRun;

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
     * Bio terms separated by commas or lines.
     */
    public function withBioContains(string $bioContains): self
    {
        $self = clone $this;
        $self['bioContains'] = $bioContains;

        return $self;
    }

    /**
     * Return only Blue-verified Tweet authors.
     */
    public function withBlueVerifiedOnly(bool $blueVerifiedOnly): self
    {
        $self = clone $this;
        $self['blueVerifiedOnly'] = $blueVerifiedOnly;

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
     * Match the Tweet card name.
     */
    public function withCardName(string $cardName): self
    {
        $self = clone $this;
        $self['cardName'] = $cardName;

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
     * Reply collection strategy.
     *
     * @param CollectionStrategy|value-of<CollectionStrategy> $collectionStrategy
     */
    public function withCollectionStrategy(
        CollectionStrategy|string $collectionStrategy
    ): self {
        $self = clone $this;
        $self['collectionStrategy'] = $collectionStrategy;

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
     * Merge duplicate results across collection targets.
     */
    public function withDedupeAcrossTargets(bool $dedupeAcrossTargets): self
    {
        $self = clone $this;
        $self['dedupeAcrossTargets'] = $dedupeAcrossTargets;

        return $self;
    }

    /**
     * Keep target duplicates, first rows, or merged overlap.
     *
     * @param DedupeMode|value-of<DedupeMode> $dedupeMode
     */
    public function withDedupeMode(DedupeMode|string $dedupeMode): self
    {
        $self = clone $this;
        $self['dedupeMode'] = $dedupeMode;

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
     * Exclude replies from the source author.
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
     * Match latitude, longitude, and radius.
     */
    public function withGeocode(string $geocode): self
    {
        $self = clone $this;
        $self['geocode'] = $geocode;

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
     * Require a profile location.
     */
    public function withHasLocation(bool $hasLocation): self
    {
        $self = clone $this;
        $self['hasLocation'] = $hasLocation;

        return $self;
    }

    /**
     * Return only replies with media.
     */
    public function withHasMediaOnly(bool $hasMediaOnly): self
    {
        $self = clone $this;
        $self['hasMediaOnly'] = $hasMediaOnly;

        return $self;
    }

    /**
     * Require a profile website.
     */
    public function withHasWebsite(bool $hasWebsite): self
    {
        $self = clone $this;
        $self['hasWebsite'] = $hasWebsite;

        return $self;
    }

    /**
     * Include the source post in reply results.
     */
    public function withIncludeOriginalPost(bool $includeOriginalPost): self
    {
        $self = clone $this;
        $self['includeOriginalPost'] = $includeOriginalPost;

        return $self;
    }

    /**
     * Add matching search terms to collection metadata.
     */
    public function withIncludeSearchTerms(bool $includeSearchTerms): self
    {
        $self = clone $this;
        $self['includeSearchTerms'] = $includeSearchTerms;

        return $self;
    }

    /**
     * Add source target metadata to each result.
     */
    public function withIncludeTargetMetadata(bool $includeTargetMetadata): self
    {
        $self = clone $this;
        $self['includeTargetMetadata'] = $includeTargetMetadata;

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
     * Required profile location text.
     */
    public function withLocationContains(string $locationContains): self
    {
        $self = clone $this;
        $self['locationContains'] = $locationContains;

        return $self;
    }

    /**
     * Maximum nested reply depth.
     */
    public function withMaxDepth(int $maxDepth): self
    {
        $self = clone $this;
        $self['maxDepth'] = $maxDepth;

        return $self;
    }

    /**
     * Maximum follower count for profile results.
     */
    public function withMaxFollowers(int $maxFollowers): self
    {
        $self = clone $this;
        $self['maxFollowers'] = $maxFollowers;

        return $self;
    }

    /**
     * Maximum following count for profile results.
     */
    public function withMaxFollowing(int $maxFollowing): self
    {
        $self = clone $this;
        $self['maxFollowing'] = $maxFollowing;

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
     * Maximum results collected for each target.
     */
    public function withMaxItemsPerTarget(int $maxItemsPerTarget): self
    {
        $self = clone $this;
        $self['maxItemsPerTarget'] = $maxItemsPerTarget;

        return $self;
    }

    /**
     * Maximum Tweet like count.
     */
    public function withMaxLikes(int $maxLikes): self
    {
        $self = clone $this;
        $self['maxLikes'] = $maxLikes;

        return $self;
    }

    /**
     * Reply pages collected for each target.
     */
    public function withMaxPagesPerTarget(int $maxPagesPerTarget): self
    {
        $self = clone $this;
        $self['maxPagesPerTarget'] = $maxPagesPerTarget;

        return $self;
    }

    /**
     * Maximum post count for profile results.
     */
    public function withMaxPosts(int $maxPosts): self
    {
        $self = clone $this;
        $self['maxPosts'] = $maxPosts;

        return $self;
    }

    /**
     * Maximum Tweet quote count.
     */
    public function withMaxQuotes(int $maxQuotes): self
    {
        $self = clone $this;
        $self['maxQuotes'] = $maxQuotes;

        return $self;
    }

    /**
     * Maximum Tweet reply count.
     */
    public function withMaxReplies(int $maxReplies): self
    {
        $self = clone $this;
        $self['maxReplies'] = $maxReplies;

        return $self;
    }

    /**
     * Maximum Tweet repost count.
     */
    public function withMaxRetweets(int $maxRetweets): self
    {
        $self = clone $this;
        $self['maxRetweets'] = $maxRetweets;

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
     * Minimum profile age in days.
     */
    public function withMinAccountAgeDays(int $minAccountAgeDays): self
    {
        $self = clone $this;
        $self['minAccountAgeDays'] = $minAccountAgeDays;

        return $self;
    }

    /**
     * Minimum Tweet bookmark count.
     */
    public function withMinBookmarks(int $minBookmarks): self
    {
        $self = clone $this;
        $self['minBookmarks'] = $minBookmarks;

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
     * Minimum follower count for profile results.
     */
    public function withMinFollowers(int $minFollowers): self
    {
        $self = clone $this;
        $self['minFollowers'] = $minFollowers;

        return $self;
    }

    /**
     * Minimum following count for profile results.
     */
    public function withMinFollowing(int $minFollowing): self
    {
        $self = clone $this;
        $self['minFollowing'] = $minFollowing;

        return $self;
    }

    /**
     * Minimum post count for profile results.
     */
    public function withMinPosts(int $minPosts): self
    {
        $self = clone $this;
        $self['minPosts'] = $minPosts;

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
     * Minimum Tweet view count.
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
     * Shortcut for dedupeMode=merge.
     */
    public function withOverlapMode(bool $overlapMode): self
    {
        $self = clone $this;
        $self['overlapMode'] = $overlapMode;

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
     * Search ranking applied to every query.
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
     * Profile relations processed within one job.
     *
     * @param list<RelationTarget|RelationTargetShape> $relationTargets
     */
    public function withRelationTargets(array $relationTargets): self
    {
        $self = clone $this;
        $self['relationTargets'] = $relationTargets;

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
     * Enable the safe-search filter.
     */
    public function withSafe(bool $safe): self
    {
        $self = clone $this;
        $self['safe'] = $safe;

        return $self;
    }

    /**
     * Reply depth scope.
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
     * Search queries processed as one collection job.
     *
     * @param list<string> $searchQueries
     */
    public function withSearchQueries(array $searchQueries): self
    {
        $self = clone $this;
        $self['searchQueries'] = $searchQueries;

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
     * Return Tweets newer than this Tweet ID.
     */
    public function withSinceID(string $sinceID): self
    {
        $self = clone $this;
        $self['sinceID'] = $sinceID;

        return $self;
    }

    /**
     * Reply start time as ISO 8601 or Unix seconds.
     *
     * @param SinceTimeShape $sinceTime
     */
    public function withSinceTime(int|\DateTimeInterface $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Reply result order.
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
     * Resume one reply target from this cursor.
     */
    public function withStartCursor(string $startCursor): self
    {
        $self = clone $this;
        $self['startCursor'] = $startCursor;

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
     * Community IDs processed as one collection job.
     *
     * @param list<string> $targetCommunityIDs
     */
    public function withTargetCommunityIDs(array $targetCommunityIDs): self
    {
        $self = clone $this;
        $self['targetCommunityIDs'] = $targetCommunityIDs;

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
     * List IDs processed as one collection job.
     *
     * @param list<string> $targetListIDs
     */
    public function withTargetListIDs(array $targetListIDs): self
    {
        $self = clone $this;
        $self['targetListIDs'] = $targetListIDs;

        return $self;
    }

    /**
     * Mixed targets auto-routed within one job.
     *
     * @param list<TargetShape> $targets
     */
    public function withTargets(array $targets): self
    {
        $self = clone $this;
        $self['targets'] = $targets;

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

    /**
     * Tweet IDs processed as one collection job.
     *
     * @param list<string> $targetTweetIDs
     */
    public function withTargetTweetIDs(array $targetTweetIDs): self
    {
        $self = clone $this;
        $self['targetTweetIDs'] = $targetTweetIDs;

        return $self;
    }

    public function withTargetUsername(string $targetUsername): self
    {
        $self = clone $this;
        $self['targetUsername'] = $targetUsername;

        return $self;
    }

    /**
     * Usernames processed as one collection job.
     *
     * @param list<string> $targetUsernames
     */
    public function withTargetUsernames(array $targetUsernames): self
    {
        $self = clone $this;
        $self['targetUsernames'] = $targetUsernames;

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
     * Reply end time as ISO 8601 or Unix seconds.
     *
     * @param UntilTimeShape $untilTime
     */
    public function withUntilTime(int|\DateTimeInterface $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

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
     * Required username text.
     */
    public function withUsernameContains(string $usernameContains): self
    {
        $self = clone $this;
        $self['usernameContains'] = $usernameContains;

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

    /**
     * Exact profile verification type.
     */
    public function withVerifiedType(string $verifiedType): self
    {
        $self = clone $this;
        $self['verifiedType'] = $verifiedType;

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
