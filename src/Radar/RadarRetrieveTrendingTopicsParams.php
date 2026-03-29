<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get trending topics from curated sources.
 *
 * @see XTwitterScraper\Services\RadarService::retrieveTrendingTopics()
 *
 * @phpstan-type RadarRetrieveTrendingTopicsParamsShape = array{
 *   category?: string|null,
 *   count?: int|null,
 *   hours?: int|null,
 *   region?: string|null,
 *   source?: string|null,
 * }
 */
final class RadarRetrieveTrendingTopicsParams implements BaseModel
{
    /** @use SdkModel<RadarRetrieveTrendingTopicsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filter by category (general, tech, dev, etc.).
     */
    #[Optional]
    public ?string $category;

    /**
     * Number of items to return.
     */
    #[Optional]
    public ?int $count;

    /**
     * Lookback window in hours.
     */
    #[Optional]
    public ?int $hours;

    /**
     * Region filter (us, global, etc.).
     */
    #[Optional]
    public ?string $region;

    /**
     * Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia.
     */
    #[Optional]
    public ?string $source;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $category = null,
        ?int $count = null,
        ?int $hours = null,
        ?string $region = null,
        ?string $source = null,
    ): self {
        $self = new self;

        null !== $category && $self['category'] = $category;
        null !== $count && $self['count'] = $count;
        null !== $hours && $self['hours'] = $hours;
        null !== $region && $self['region'] = $region;
        null !== $source && $self['source'] = $source;

        return $self;
    }

    /**
     * Filter by category (general, tech, dev, etc.).
     */
    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Number of items to return.
     */
    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

        return $self;
    }

    /**
     * Lookback window in hours.
     */
    public function withHours(int $hours): self
    {
        $self = clone $this;
        $self['hours'] = $hours;

        return $self;
    }

    /**
     * Region filter (us, global, etc.).
     */
    public function withRegion(string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    /**
     * Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia.
     */
    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }
}
