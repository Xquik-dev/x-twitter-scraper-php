<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Radar;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Radar\RadarItem\Category;
use XTwitterScraper\Radar\RadarItem\Metadata;
use XTwitterScraper\Radar\RadarItem\Source;

/**
 * Trending topic with score, category, source, region, language, and source-specific metadata.
 *
 * @phpstan-import-type MetadataShape from \XTwitterScraper\Radar\RadarItem\Metadata
 *
 * @phpstan-type RadarItemShape = array{
 *   id: string,
 *   category: Category|value-of<Category>,
 *   createdAt: \DateTimeInterface,
 *   language: string,
 *   metadata: Metadata|MetadataShape,
 *   publishedAt: \DateTimeInterface,
 *   region: string,
 *   score: float,
 *   source: Source|value-of<Source>,
 *   sourceID: string,
 *   title: string,
 *   description?: string|null,
 *   imageURL?: string|null,
 *   url?: string|null,
 * }
 */
final class RadarItem implements BaseModel
{
    /** @use SdkModel<RadarItemShape> */
    use SdkModel;

    /**
     * Radar item identifier.
     */
    #[Required]
    public string $id;

    /** @var value-of<Category> $category */
    #[Required(enum: Category::class)]
    public string $category;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * BCP-47 language code. und means the source did not identify a language.
     */
    #[Required]
    public string $language;

    /**
     * Source-specific fields. Shape varies per source:
     * - reddit: { author, authorId?, subreddit, subredditId?,
     *   subredditSubscribers?, sourceFormat, score?, upvoteRatio?,
     *   estimatedUpvotes?, estimatedDownvotes?, numberComments?,
     *   numberCrossposts?, selftext?, contentUrl?, domain?, postHint?,
     *   linkFlairText?, distinguished?, totalAwardsReceived?, viewCount?,
     *   editedAt?, galleryImageUrls?, redditVideo?, archived?, contestMode?,
     *   isCrosspostable?, isMeta?, isNsfw?, isOriginalContent?,
     *   isRobotIndexable?, isSelf?, isSpoiler?, isVideo?, locked?,
     *   stickied? }. `score` is Reddit's public net score. Exact public
     *   upvote and downvote counts are not available. Estimated counts
     *   derive from the public score and upvote ratio, which Reddit may
     *   fuzz. Comment bodies are not included. Current items combine
     *   public listing discovery with server-rendered post data and use
     *   `sourceFormat: html`; `json` and `rss` remain for legacy rows.
     * - github: { starsToday: number }
     * - hacker_news: { points: number, numberComments: number }
     * - google_trends: { approxTraffic: number }
     * - polymarket: { volume24hr: number }
     * - wikipedia: { views: number }
     * - trustmrr: { mrr, growthPercent, last30Days, total, customers, activeSubscriptions, onSale, xHandle?, category?, askingPrice?, country?, foundedDate?, googleSearchImpressionsLast30Days?, growthMrrPercent?, multiple?, paymentProvider?, profitMarginLast30Days?, rank?, revenuePerVisitor?, targetAudience?, visitorsLast30Days? }
     * For the startup growth source, xHandle is the founder's X username
     * without @. The rank field is the source's revenue rank. Result order
     * represents reported 30-day revenue-growth rank.
     */
    #[Required]
    public Metadata $metadata;

    #[Required]
    public \DateTimeInterface $publishedAt;

    #[Required]
    public string $region;

    #[Required]
    public float $score;

    /** @var value-of<Source> $source */
    #[Required(enum: Source::class)]
    public string $source;

    /**
     * Source-specific identifier used for deduplication.
     */
    #[Required('sourceId')]
    public string $sourceID;

    #[Required]
    public string $title;

    #[Optional]
    public ?string $description;

    /**
     * Source image. Startup growth items return the logo here.
     */
    #[Optional('imageUrl')]
    public ?string $imageURL;

    #[Optional]
    public ?string $url;

    /**
     * `new RadarItem()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RadarItem::with(
     *   id: ...,
     *   category: ...,
     *   createdAt: ...,
     *   language: ...,
     *   metadata: ...,
     *   publishedAt: ...,
     *   region: ...,
     *   score: ...,
     *   source: ...,
     *   sourceID: ...,
     *   title: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RadarItem)
     *   ->withID(...)
     *   ->withCategory(...)
     *   ->withCreatedAt(...)
     *   ->withLanguage(...)
     *   ->withMetadata(...)
     *   ->withPublishedAt(...)
     *   ->withRegion(...)
     *   ->withScore(...)
     *   ->withSource(...)
     *   ->withSourceID(...)
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
     *
     * @param Category|value-of<Category> $category
     * @param Metadata|MetadataShape $metadata
     * @param Source|value-of<Source> $source
     */
    public static function with(
        string $id,
        Category|string $category,
        \DateTimeInterface $createdAt,
        string $language,
        Metadata|array $metadata,
        \DateTimeInterface $publishedAt,
        string $region,
        float $score,
        Source|string $source,
        string $sourceID,
        string $title,
        ?string $description = null,
        ?string $imageURL = null,
        ?string $url = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['category'] = $category;
        $self['createdAt'] = $createdAt;
        $self['language'] = $language;
        $self['metadata'] = $metadata;
        $self['publishedAt'] = $publishedAt;
        $self['region'] = $region;
        $self['score'] = $score;
        $self['source'] = $source;
        $self['sourceID'] = $sourceID;
        $self['title'] = $title;

        null !== $description && $self['description'] = $description;
        null !== $imageURL && $self['imageURL'] = $imageURL;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * Radar item identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Category|value-of<Category> $category
     */
    public function withCategory(Category|string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * BCP-47 language code. und means the source did not identify a language.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Source-specific fields. Shape varies per source:
     * - reddit: { author, authorId?, subreddit, subredditId?,
     *   subredditSubscribers?, sourceFormat, score?, upvoteRatio?,
     *   estimatedUpvotes?, estimatedDownvotes?, numberComments?,
     *   numberCrossposts?, selftext?, contentUrl?, domain?, postHint?,
     *   linkFlairText?, distinguished?, totalAwardsReceived?, viewCount?,
     *   editedAt?, galleryImageUrls?, redditVideo?, archived?, contestMode?,
     *   isCrosspostable?, isMeta?, isNsfw?, isOriginalContent?,
     *   isRobotIndexable?, isSelf?, isSpoiler?, isVideo?, locked?,
     *   stickied? }. `score` is Reddit's public net score. Exact public
     *   upvote and downvote counts are not available. Estimated counts
     *   derive from the public score and upvote ratio, which Reddit may
     *   fuzz. Comment bodies are not included. Current items combine
     *   public listing discovery with server-rendered post data and use
     *   `sourceFormat: html`; `json` and `rss` remain for legacy rows.
     * - github: { starsToday: number }
     * - hacker_news: { points: number, numberComments: number }
     * - google_trends: { approxTraffic: number }
     * - polymarket: { volume24hr: number }
     * - wikipedia: { views: number }
     * - trustmrr: { mrr, growthPercent, last30Days, total, customers, activeSubscriptions, onSale, xHandle?, category?, askingPrice?, country?, foundedDate?, googleSearchImpressionsLast30Days?, growthMrrPercent?, multiple?, paymentProvider?, profitMarginLast30Days?, rank?, revenuePerVisitor?, targetAudience?, visitorsLast30Days? }
     * For the startup growth source, xHandle is the founder's X username
     * without @. The rank field is the source's revenue rank. Result order
     * represents reported 30-day revenue-growth rank.
     *
     * @param Metadata|MetadataShape $metadata
     */
    public function withMetadata(Metadata|array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

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

    /**
     * @param Source|value-of<Source> $source
     */
    public function withSource(Source|string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Source-specific identifier used for deduplication.
     */
    public function withSourceID(string $sourceID): self
    {
        $self = clone $this;
        $self['sourceID'] = $sourceID;

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

    /**
     * Source image. Startup growth items return the logo here.
     */
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
