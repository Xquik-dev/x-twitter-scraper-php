<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Category;
use XTwitterScraper\Radar\RadarRetrieveTrendingTopicsParams\Source;

/**
 * Get trending topics from curated sources.
 *
 * @see XTwitterScraper\Services\RadarService::retrieveTrendingTopics()
 *
 * @phpstan-type RadarRetrieveTrendingTopicsParamsShape = array{
 *   after?: string|null,
 *   category?: null|Category|value-of<Category>,
 *   hours?: int|null,
 *   limit?: int|null,
 *   region?: string|null,
 *   source?: null|Source|value-of<Source>,
 * }
 */
final class RadarRetrieveTrendingTopicsParams implements BaseModel
{
    /** @use SdkModel<RadarRetrieveTrendingTopicsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Cursor for pagination (from prior response nextCursor).
     */
    #[Optional]
    public ?string $after;

    /**
     * Filter by category.
     *
     * @var value-of<Category>|null $category
     */
    #[Optional(enum: Category::class)]
    public ?string $category;

    /**
     * Lookback window in hours (1-168, default 24).
     */
    #[Optional]
    public ?int $hours;

    /**
     * Number of items to return (1-100, default 50).
     */
    #[Optional]
    public ?int $limit;

    /**
     * Region filter (us, global, etc.).
     */
    #[Optional]
    public ?string $region;

    /**
     * Source filter. One of: github, google_trends, hacker_news, polymarket, reddit, trustmrr, wikipedia.
     *
     * @var value-of<Source>|null $source
     */
    #[Optional(enum: Source::class)]
    public ?string $source;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Category|value-of<Category>|null $category
     * @param Source|value-of<Source>|null $source
     */
    public static function with(
        ?string $after = null,
        Category|string|null $category = null,
        ?int $hours = null,
        ?int $limit = null,
        ?string $region = null,
        Source|string|null $source = null,
    ): self {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $category && $self['category'] = $category;
        null !== $hours && $self['hours'] = $hours;
        null !== $limit && $self['limit'] = $limit;
        null !== $region && $self['region'] = $region;
        null !== $source && $self['source'] = $source;

        return $self;
    }

    /**
     * Cursor for pagination (from prior response nextCursor).
     */
    public function withAfter(string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

        return $self;
    }

    /**
     * Filter by category.
     *
     * @param Category|value-of<Category> $category
     */
    public function withCategory(Category|string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Lookback window in hours (1-168, default 24).
     */
    public function withHours(int $hours): self
    {
        $self = clone $this;
        $self['hours'] = $hours;

        return $self;
    }

    /**
     * Number of items to return (1-100, default 50).
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

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
     *
     * @param Source|value-of<Source> $source
     */
    public function withSource(Source|string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }
}
