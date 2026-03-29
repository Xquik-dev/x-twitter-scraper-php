<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\ToolType;

/**
 * Estimate extraction cost.
 *
 * @see XTwitterScraper\Services\ExtractionsService::estimateCost()
 *
 * @phpstan-type ExtractionEstimateCostParamsShape = array{
 *   toolType: ToolType|value-of<ToolType>,
 *   advancedQuery?: string|null,
 *   exactPhrase?: string|null,
 *   excludeWords?: string|null,
 *   searchQuery?: string|null,
 *   targetCommunityID?: string|null,
 *   targetListID?: string|null,
 *   targetSpaceID?: string|null,
 *   targetTweetID?: string|null,
 *   targetUsername?: string|null,
 * }
 */
final class ExtractionEstimateCostParams implements BaseModel
{
    /** @use SdkModel<ExtractionEstimateCostParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var value-of<ToolType> $toolType */
    #[Required(enum: ToolType::class)]
    public string $toolType;

    /**
     * Raw advanced search query appended as-is (tweet_search_extractor).
     */
    #[Optional]
    public ?string $advancedQuery;

    /**
     * Exact phrase to match (tweet_search_extractor).
     */
    #[Optional]
    public ?string $exactPhrase;

    /**
     * Words to exclude from results (tweet_search_extractor).
     */
    #[Optional]
    public ?string $excludeWords;

    #[Optional]
    public ?string $searchQuery;

    #[Optional('targetCommunityId')]
    public ?string $targetCommunityID;

    #[Optional('targetListId')]
    public ?string $targetListID;

    #[Optional('targetSpaceId')]
    public ?string $targetSpaceID;

    #[Optional('targetTweetId')]
    public ?string $targetTweetID;

    #[Optional]
    public ?string $targetUsername;

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
     */
    public static function with(
        ToolType|string $toolType,
        ?string $advancedQuery = null,
        ?string $exactPhrase = null,
        ?string $excludeWords = null,
        ?string $searchQuery = null,
        ?string $targetCommunityID = null,
        ?string $targetListID = null,
        ?string $targetSpaceID = null,
        ?string $targetTweetID = null,
        ?string $targetUsername = null,
    ): self {
        $self = new self;

        $self['toolType'] = $toolType;

        null !== $advancedQuery && $self['advancedQuery'] = $advancedQuery;
        null !== $exactPhrase && $self['exactPhrase'] = $exactPhrase;
        null !== $excludeWords && $self['excludeWords'] = $excludeWords;
        null !== $searchQuery && $self['searchQuery'] = $searchQuery;
        null !== $targetCommunityID && $self['targetCommunityID'] = $targetCommunityID;
        null !== $targetListID && $self['targetListID'] = $targetListID;
        null !== $targetSpaceID && $self['targetSpaceID'] = $targetSpaceID;
        null !== $targetTweetID && $self['targetTweetID'] = $targetTweetID;
        null !== $targetUsername && $self['targetUsername'] = $targetUsername;

        return $self;
    }

    /**
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
     * Exact phrase to match (tweet_search_extractor).
     */
    public function withExactPhrase(string $exactPhrase): self
    {
        $self = clone $this;
        $self['exactPhrase'] = $exactPhrase;

        return $self;
    }

    /**
     * Words to exclude from results (tweet_search_extractor).
     */
    public function withExcludeWords(string $excludeWords): self
    {
        $self = clone $this;
        $self['excludeWords'] = $excludeWords;

        return $self;
    }

    public function withSearchQuery(string $searchQuery): self
    {
        $self = clone $this;
        $self['searchQuery'] = $searchQuery;

        return $self;
    }

    public function withTargetCommunityID(string $targetCommunityID): self
    {
        $self = clone $this;
        $self['targetCommunityID'] = $targetCommunityID;

        return $self;
    }

    public function withTargetListID(string $targetListID): self
    {
        $self = clone $this;
        $self['targetListID'] = $targetListID;

        return $self;
    }

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
}
