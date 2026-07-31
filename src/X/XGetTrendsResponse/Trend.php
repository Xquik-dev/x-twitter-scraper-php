<?php

declare(strict_types=1);

namespace XTwitterScraper\X\XGetTrendsResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TrendShape = array{
 *   name: string,
 *   description?: string|null,
 *   promotedContent?: string|null,
 *   query?: string|null,
 *   rank?: int|null,
 *   tweetVolume?: int|null,
 *   url?: string|null,
 * }
 */
final class Trend implements BaseModel
{
    /** @use SdkModel<TrendShape> */
    use SdkModel;

    #[Required]
    public string $name;

    #[Optional]
    public ?string $description;

    /**
     * Promotion identifier from X. Null for organic trends.
     */
    #[Optional(nullable: true)]
    public ?string $promotedContent;

    #[Optional]
    public ?string $query;

    #[Optional]
    public ?int $rank;

    /**
     * Approximate public post volume when X supplies it.
     */
    #[Optional(nullable: true)]
    public ?int $tweetVolume;

    /**
     * X search URL for the trend.
     */
    #[Optional]
    public ?string $url;

    /**
     * `new Trend()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Trend::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Trend)->withName(...)
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
        string $name,
        ?string $description = null,
        ?string $promotedContent = null,
        ?string $query = null,
        ?int $rank = null,
        ?int $tweetVolume = null,
        ?string $url = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;
        null !== $promotedContent && $self['promotedContent'] = $promotedContent;
        null !== $query && $self['query'] = $query;
        null !== $rank && $self['rank'] = $rank;
        null !== $tweetVolume && $self['tweetVolume'] = $tweetVolume;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Promotion identifier from X. Null for organic trends.
     */
    public function withPromotedContent(?string $promotedContent): self
    {
        $self = clone $this;
        $self['promotedContent'] = $promotedContent;

        return $self;
    }

    public function withQuery(string $query): self
    {
        $self = clone $this;
        $self['query'] = $query;

        return $self;
    }

    public function withRank(int $rank): self
    {
        $self = clone $this;
        $self['rank'] = $rank;

        return $self;
    }

    /**
     * Approximate public post volume when X supplies it.
     */
    public function withTweetVolume(?int $tweetVolume): self
    {
        $self = clone $this;
        $self['tweetVolume'] = $tweetVolume;

        return $self;
    }

    /**
     * X search URL for the trend.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
