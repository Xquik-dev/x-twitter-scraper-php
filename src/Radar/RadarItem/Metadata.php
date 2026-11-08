<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar\RadarItem;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Radar\RadarItem\Metadata\Sentiment;
use XTwitterScraper\Radar\RadarItem\Metadata\SourceFormat;
use XTwitterScraper\Radar\RadarItem\Metadata\Windows;

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
 *   fuzz. Comment bodies are not included. Current items use
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
 * @phpstan-type MetadataShape = array{
 *   author?: string|null,
 *   contentURL?: string|null,
 *   estimatedDownvotes?: int|null,
 *   estimatedUpvotes?: int|null,
 *   numberComments?: int|null,
 *   score?: int|null,
 *   selftext?: string|null,
 *   sourceFormat?: null|SourceFormat|value-of<SourceFormat>,
 *   subreddit?: string|null,
 *   upvoteRatio?: float|null,
 *   sentiment?: Sentiment|value-of<Sentiment>|null,
 *   windows?: list<Windows|value-of<Windows>>|null,
 * }
 */
final class Metadata implements BaseModel
{
    /** @use SdkModel<MetadataShape> */
    use SdkModel;

    #[Optional]
    public ?string $author;

    #[Optional('contentUrl')]
    public ?string $contentURL;

    #[Optional]
    public ?int $estimatedDownvotes;

    #[Optional]
    public ?int $estimatedUpvotes;

    #[Optional]
    public ?int $numberComments;

    #[Optional]
    public ?int $score;

    #[Optional]
    public ?string $selftext;

    /**
     * Current items use html. json and rss are retained for legacy rows.
     *
     * @var value-of<SourceFormat>|null $sourceFormat
     */
    #[Optional(enum: SourceFormat::class)]
    public ?string $sourceFormat;

    #[Optional]
    public ?string $subreddit;

    #[Optional]
    public ?float $upvoteRatio;

    /**
     * Tone of an English post title, from the VADER word list.
     *
     * @var value-of<Sentiment>|null $sentiment
     */
    #[Optional(enum: Sentiment::class)]
    public ?string $sentiment;

    /**
     * Reddit lists the post ranks in. now is the popular feed, and the rest are top lists of that window.
     *
     * @var list<value-of<Windows>>|null $windows
     */
    #[Optional(list: Windows::class)]
    public ?array $windows;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param SourceFormat|value-of<SourceFormat>|null $sourceFormat
     * @param Sentiment|value-of<Sentiment>|null $sentiment
     * @param list<Windows|value-of<Windows>>|null $windows
     */
    public static function with(
        ?string $author = null,
        ?string $contentURL = null,
        ?int $estimatedDownvotes = null,
        ?int $estimatedUpvotes = null,
        ?int $numberComments = null,
        ?int $score = null,
        ?string $selftext = null,
        SourceFormat|string|null $sourceFormat = null,
        ?string $subreddit = null,
        ?float $upvoteRatio = null,
        Sentiment|string|null $sentiment = null,
        ?array $windows = null
    ): self {
        $self = new self;

        null !== $author && $self['author'] = $author;
        null !== $contentURL && $self['contentURL'] = $contentURL;
        null !== $estimatedDownvotes && $self['estimatedDownvotes'] = $estimatedDownvotes;
        null !== $estimatedUpvotes && $self['estimatedUpvotes'] = $estimatedUpvotes;
        null !== $numberComments && $self['numberComments'] = $numberComments;
        null !== $score && $self['score'] = $score;
        null !== $selftext && $self['selftext'] = $selftext;
        null !== $sourceFormat && $self['sourceFormat'] = $sourceFormat;
        null !== $subreddit && $self['subreddit'] = $subreddit;
        null !== $upvoteRatio && $self['upvoteRatio'] = $upvoteRatio;

        null !== $sentiment && $self['sentiment'] = $sentiment;

        null !== $windows && $self['windows'] = $windows;

        return $self;
    }

    public function withAuthor(string $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }

    public function withContentURL(string $contentURL): self
    {
        $self = clone $this;
        $self['contentURL'] = $contentURL;

        return $self;
    }

    public function withEstimatedDownvotes(int $estimatedDownvotes): self
    {
        $self = clone $this;
        $self['estimatedDownvotes'] = $estimatedDownvotes;

        return $self;
    }

    public function withEstimatedUpvotes(int $estimatedUpvotes): self
    {
        $self = clone $this;
        $self['estimatedUpvotes'] = $estimatedUpvotes;

        return $self;
    }

    public function withNumberComments(int $numberComments): self
    {
        $self = clone $this;
        $self['numberComments'] = $numberComments;

        return $self;
    }

    public function withScore(int $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }

    public function withSelftext(string $selftext): self
    {
        $self = clone $this;
        $self['selftext'] = $selftext;

        return $self;
    }

    /**
     * Current items use html. json and rss are retained for legacy rows.
     *
     * @param SourceFormat|value-of<SourceFormat> $sourceFormat
     */
    public function withSourceFormat(SourceFormat|string $sourceFormat): self
    {
        $self = clone $this;
        $self['sourceFormat'] = $sourceFormat;

        return $self;
    }

    public function withSubreddit(string $subreddit): self
    {
        $self = clone $this;
        $self['subreddit'] = $subreddit;

        return $self;
    }

    public function withUpvoteRatio(float $upvoteRatio): self
    {
        $self = clone $this;
        $self['upvoteRatio'] = $upvoteRatio;

        return $self;
    }

    /**
     * Tone of an English post title, from the VADER word list.
     *
     * @param Sentiment|value-of<Sentiment>|null $sentiment
     */
    public function withSentiment(Sentiment|string|null $sentiment): self
    {
        $self = clone $this;
        $self['sentiment'] = $sentiment;

        return $self;
    }

    /**
     * Reddit lists the post ranks in. now is the popular feed, and the rest are top lists of that window.
     *
     * @param list<Windows|value-of<Windows>>|null $windows
     */
    public function withWindows(?array $windows): self
    {
        $self = clone $this;
        $self['windows'] = $windows;

        return $self;
    }
}
