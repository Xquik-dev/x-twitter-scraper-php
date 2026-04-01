<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar\RadarGetTrendingTopicsResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type ItemShape = array{
 *   category: string,
 *   publishedAt: \DateTimeInterface,
 *   region: string,
 *   score: float,
 *   source: string,
 *   title: string,
 *   description?: string|null,
 *   imageURL?: string|null,
 *   url?: string|null,
 * }
 */
final class Item implements BaseModel
{
    /** @use SdkModel<ItemShape> */
    use SdkModel;

    #[Required]
    public string $category;

    #[Required]
    public \DateTimeInterface $publishedAt;

    #[Required]
    public string $region;

    #[Required]
    public float $score;

    #[Required]
    public string $source;

    #[Required]
    public string $title;

    #[Optional]
    public ?string $description;

    #[Optional('imageUrl')]
    public ?string $imageURL;

    #[Optional]
    public ?string $url;

    /**
     * `new Item()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Item::with(
     *   category: ...,
     *   publishedAt: ...,
     *   region: ...,
     *   score: ...,
     *   source: ...,
     *   title: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Item)
     *   ->withCategory(...)
     *   ->withPublishedAt(...)
     *   ->withRegion(...)
     *   ->withScore(...)
     *   ->withSource(...)
     *   ->withTitle(...)
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
     */
    public static function with(
        string $category,
        \DateTimeInterface $publishedAt,
        string $region,
        float $score,
        string $source,
        string $title,
        ?string $description = null,
        ?string $imageURL = null,
        ?string $url = null,
    ): self {
        $self = new self;

        $self['category'] = $category;
        $self['publishedAt'] = $publishedAt;
        $self['region'] = $region;
        $self['score'] = $score;
        $self['source'] = $source;
        $self['title'] = $title;

        null !== $description && $self['description'] = $description;
        null !== $imageURL && $self['imageURL'] = $imageURL;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withCategory(string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    public function withPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $self = clone $this;
        $self['publishedAt'] = $publishedAt;

        return $self;
    }

    public function withRegion(string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    public function withScore(float $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withImageURL(string $imageURL): self
    {
        $self = clone $this;
        $self['imageURL'] = $imageURL;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
