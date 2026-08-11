<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionExportResultsParams\Format;

/**
 * Export extraction results.
 *
 * @see XTwitterScraper\Services\ExtractionsService::exportResults()
 *
 * @phpstan-type ExtractionExportResultsParamsShape = array{
 *   format: Format|value-of<Format>,
 *   hasDescription?: bool|null,
 *   hasLocation?: bool|null,
 *   hasMedia?: bool|null,
 *   lang?: string|null,
 *   maxFollowers?: int|null,
 *   maxFollowing?: int|null,
 *   maxPosts?: int|null,
 *   minFollowers?: int|null,
 *   minFollowing?: int|null,
 *   minLikes?: int|null,
 *   minPosts?: int|null,
 *   minReplies?: int|null,
 *   minRetweets?: int|null,
 *   minViews?: int|null,
 *   search?: string|null,
 *   sinceDate?: string|null,
 *   untilDate?: string|null,
 *   verified?: bool|null,
 * }
 */
final class ExtractionExportResultsParams implements BaseModel
{
    /** @use SdkModel<ExtractionExportResultsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Export file format.
     *
     * @var value-of<Format> $format
     */
    #[Required(enum: Format::class)]
    public string $format;

    /**
     * Require a non-empty description.
     */
    #[Optional]
    public ?bool $hasDescription;

    /**
     * Require a non-empty location.
     */
    #[Optional]
    public ?bool $hasLocation;

    /**
     * Require media.
     */
    #[Optional]
    public ?bool $hasMedia;

    /**
     * Filter by language code.
     */
    #[Optional]
    public ?string $lang;

    /**
     * Maximum follower count.
     */
    #[Optional]
    public ?int $maxFollowers;

    /**
     * Maximum following count.
     */
    #[Optional]
    public ?int $maxFollowing;

    /**
     * Maximum post count.
     */
    #[Optional]
    public ?int $maxPosts;

    /**
     * Minimum follower count.
     */
    #[Optional]
    public ?int $minFollowers;

    /**
     * Minimum following count.
     */
    #[Optional]
    public ?int $minFollowing;

    /**
     * Minimum like count.
     */
    #[Optional]
    public ?int $minLikes;

    /**
     * Minimum post count.
     */
    #[Optional]
    public ?int $minPosts;

    /**
     * Minimum reply count.
     */
    #[Optional]
    public ?int $minReplies;

    /**
     * Minimum repost count.
     */
    #[Optional]
    public ?int $minRetweets;

    /**
     * Minimum view count.
     */
    #[Optional]
    public ?int $minViews;

    /**
     * Search exported result text.
     */
    #[Optional]
    public ?string $search;

    /**
     * Include results on or after this date.
     */
    #[Optional]
    public ?string $sinceDate;

    /**
     * Include results on or before this date.
     */
    #[Optional]
    public ?string $untilDate;

    /**
     * Filter by verified status.
     */
    #[Optional]
    public ?bool $verified;

    /**
     * `new ExtractionExportResultsParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionExportResultsParams::with(format: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionExportResultsParams)->withFormat(...)
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
     * @param Format|value-of<Format> $format
     */
    public static function with(
        Format|string $format,
        ?bool $hasDescription = null,
        ?bool $hasLocation = null,
        ?bool $hasMedia = null,
        ?string $lang = null,
        ?int $maxFollowers = null,
        ?int $maxFollowing = null,
        ?int $maxPosts = null,
        ?int $minFollowers = null,
        ?int $minFollowing = null,
        ?int $minLikes = null,
        ?int $minPosts = null,
        ?int $minReplies = null,
        ?int $minRetweets = null,
        ?int $minViews = null,
        ?string $search = null,
        ?string $sinceDate = null,
        ?string $untilDate = null,
        ?bool $verified = null,
    ): self {
        $self = new self;

        $self['format'] = $format;

        null !== $hasDescription && $self['hasDescription'] = $hasDescription;
        null !== $hasLocation && $self['hasLocation'] = $hasLocation;
        null !== $hasMedia && $self['hasMedia'] = $hasMedia;
        null !== $lang && $self['lang'] = $lang;
        null !== $maxFollowers && $self['maxFollowers'] = $maxFollowers;
        null !== $maxFollowing && $self['maxFollowing'] = $maxFollowing;
        null !== $maxPosts && $self['maxPosts'] = $maxPosts;
        null !== $minFollowers && $self['minFollowers'] = $minFollowers;
        null !== $minFollowing && $self['minFollowing'] = $minFollowing;
        null !== $minLikes && $self['minLikes'] = $minLikes;
        null !== $minPosts && $self['minPosts'] = $minPosts;
        null !== $minReplies && $self['minReplies'] = $minReplies;
        null !== $minRetweets && $self['minRetweets'] = $minRetweets;
        null !== $minViews && $self['minViews'] = $minViews;
        null !== $search && $self['search'] = $search;
        null !== $sinceDate && $self['sinceDate'] = $sinceDate;
        null !== $untilDate && $self['untilDate'] = $untilDate;
        null !== $verified && $self['verified'] = $verified;

        return $self;
    }

    /**
     * Export file format.
     *
     * @param Format|value-of<Format> $format
     */
    public function withFormat(Format|string $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }

    /**
     * Require a non-empty description.
     */
    public function withHasDescription(bool $hasDescription): self
    {
        $self = clone $this;
        $self['hasDescription'] = $hasDescription;

        return $self;
    }

    /**
     * Require a non-empty location.
     */
    public function withHasLocation(bool $hasLocation): self
    {
        $self = clone $this;
        $self['hasLocation'] = $hasLocation;

        return $self;
    }

    /**
     * Require media.
     */
    public function withHasMedia(bool $hasMedia): self
    {
        $self = clone $this;
        $self['hasMedia'] = $hasMedia;

        return $self;
    }

    /**
     * Filter by language code.
     */
    public function withLang(string $lang): self
    {
        $self = clone $this;
        $self['lang'] = $lang;

        return $self;
    }

    /**
     * Maximum follower count.
     */
    public function withMaxFollowers(int $maxFollowers): self
    {
        $self = clone $this;
        $self['maxFollowers'] = $maxFollowers;

        return $self;
    }

    /**
     * Maximum following count.
     */
    public function withMaxFollowing(int $maxFollowing): self
    {
        $self = clone $this;
        $self['maxFollowing'] = $maxFollowing;

        return $self;
    }

    /**
     * Maximum post count.
     */
    public function withMaxPosts(int $maxPosts): self
    {
        $self = clone $this;
        $self['maxPosts'] = $maxPosts;

        return $self;
    }

    /**
     * Minimum follower count.
     */
    public function withMinFollowers(int $minFollowers): self
    {
        $self = clone $this;
        $self['minFollowers'] = $minFollowers;

        return $self;
    }

    /**
     * Minimum following count.
     */
    public function withMinFollowing(int $minFollowing): self
    {
        $self = clone $this;
        $self['minFollowing'] = $minFollowing;

        return $self;
    }

    /**
     * Minimum like count.
     */
    public function withMinLikes(int $minLikes): self
    {
        $self = clone $this;
        $self['minLikes'] = $minLikes;

        return $self;
    }

    /**
     * Minimum post count.
     */
    public function withMinPosts(int $minPosts): self
    {
        $self = clone $this;
        $self['minPosts'] = $minPosts;

        return $self;
    }

    /**
     * Minimum reply count.
     */
    public function withMinReplies(int $minReplies): self
    {
        $self = clone $this;
        $self['minReplies'] = $minReplies;

        return $self;
    }

    /**
     * Minimum repost count.
     */
    public function withMinRetweets(int $minRetweets): self
    {
        $self = clone $this;
        $self['minRetweets'] = $minRetweets;

        return $self;
    }

    /**
     * Minimum view count.
     */
    public function withMinViews(int $minViews): self
    {
        $self = clone $this;
        $self['minViews'] = $minViews;

        return $self;
    }

    /**
     * Search exported result text.
     */
    public function withSearch(string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Include results on or after this date.
     */
    public function withSinceDate(string $sinceDate): self
    {
        $self = clone $this;
        $self['sinceDate'] = $sinceDate;

        return $self;
    }

    /**
     * Include results on or before this date.
     */
    public function withUntilDate(string $untilDate): self
    {
        $self = clone $this;
        $self['untilDate'] = $untilDate;

        return $self;
    }

    /**
     * Filter by verified status.
     */
    public function withVerified(bool $verified): self
    {
        $self = clone $this;
        $self['verified'] = $verified;

        return $self;
    }
}
