<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Run giveaway draw.
 *
 * @see XTwitterScraper\Services\DrawsService::run()
 *
 * @phpstan-type DrawRunParamsShape = array{
 *   tweetURL: string,
 *   backupCount?: int|null,
 *   filterAccountAgeDays?: int|null,
 *   filterLanguage?: string|null,
 *   filterMinFollowers?: int|null,
 *   mustFollowUsername?: string|null,
 *   mustRetweet?: bool|null,
 *   requiredHashtags?: list<string>|null,
 *   requiredKeywords?: list<string>|null,
 *   requiredMentions?: list<string>|null,
 *   uniqueAuthorsOnly?: bool|null,
 *   winnerCount?: int|null,
 * }
 */
final class DrawRunParams implements BaseModel
{
    /** @use SdkModel<DrawRunParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required('tweetUrl')]
    public string $tweetURL;

    #[Optional]
    public ?int $backupCount;

    #[Optional]
    public ?int $filterAccountAgeDays;

    #[Optional]
    public ?string $filterLanguage;

    #[Optional]
    public ?int $filterMinFollowers;

    #[Optional]
    public ?string $mustFollowUsername;

    #[Optional]
    public ?bool $mustRetweet;

    /** @var list<string>|null $requiredHashtags */
    #[Optional(list: 'string')]
    public ?array $requiredHashtags;

    /** @var list<string>|null $requiredKeywords */
    #[Optional(list: 'string')]
    public ?array $requiredKeywords;

    /** @var list<string>|null $requiredMentions */
    #[Optional(list: 'string')]
    public ?array $requiredMentions;

    #[Optional]
    public ?bool $uniqueAuthorsOnly;

    #[Optional]
    public ?int $winnerCount;

    /**
     * `new DrawRunParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DrawRunParams::with(tweetURL: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DrawRunParams)->withTweetURL(...)
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
     * @param list<string>|null $requiredHashtags
     * @param list<string>|null $requiredKeywords
     * @param list<string>|null $requiredMentions
     */
    public static function with(
        string $tweetURL,
        ?int $backupCount = null,
        ?int $filterAccountAgeDays = null,
        ?string $filterLanguage = null,
        ?int $filterMinFollowers = null,
        ?string $mustFollowUsername = null,
        ?bool $mustRetweet = null,
        ?array $requiredHashtags = null,
        ?array $requiredKeywords = null,
        ?array $requiredMentions = null,
        ?bool $uniqueAuthorsOnly = null,
        ?int $winnerCount = null,
    ): self {
        $self = new self;

        $self['tweetURL'] = $tweetURL;

        null !== $backupCount && $self['backupCount'] = $backupCount;
        null !== $filterAccountAgeDays && $self['filterAccountAgeDays'] = $filterAccountAgeDays;
        null !== $filterLanguage && $self['filterLanguage'] = $filterLanguage;
        null !== $filterMinFollowers && $self['filterMinFollowers'] = $filterMinFollowers;
        null !== $mustFollowUsername && $self['mustFollowUsername'] = $mustFollowUsername;
        null !== $mustRetweet && $self['mustRetweet'] = $mustRetweet;
        null !== $requiredHashtags && $self['requiredHashtags'] = $requiredHashtags;
        null !== $requiredKeywords && $self['requiredKeywords'] = $requiredKeywords;
        null !== $requiredMentions && $self['requiredMentions'] = $requiredMentions;
        null !== $uniqueAuthorsOnly && $self['uniqueAuthorsOnly'] = $uniqueAuthorsOnly;
        null !== $winnerCount && $self['winnerCount'] = $winnerCount;

        return $self;
    }

    public function withTweetURL(string $tweetURL): self
    {
        $self = clone $this;
        $self['tweetURL'] = $tweetURL;

        return $self;
    }

    public function withBackupCount(int $backupCount): self
    {
        $self = clone $this;
        $self['backupCount'] = $backupCount;

        return $self;
    }

    public function withFilterAccountAgeDays(int $filterAccountAgeDays): self
    {
        $self = clone $this;
        $self['filterAccountAgeDays'] = $filterAccountAgeDays;

        return $self;
    }

    public function withFilterLanguage(string $filterLanguage): self
    {
        $self = clone $this;
        $self['filterLanguage'] = $filterLanguage;

        return $self;
    }

    public function withFilterMinFollowers(int $filterMinFollowers): self
    {
        $self = clone $this;
        $self['filterMinFollowers'] = $filterMinFollowers;

        return $self;
    }

    public function withMustFollowUsername(string $mustFollowUsername): self
    {
        $self = clone $this;
        $self['mustFollowUsername'] = $mustFollowUsername;

        return $self;
    }

    public function withMustRetweet(bool $mustRetweet): self
    {
        $self = clone $this;
        $self['mustRetweet'] = $mustRetweet;

        return $self;
    }

    /**
     * @param list<string> $requiredHashtags
     */
    public function withRequiredHashtags(array $requiredHashtags): self
    {
        $self = clone $this;
        $self['requiredHashtags'] = $requiredHashtags;

        return $self;
    }

    /**
     * @param list<string> $requiredKeywords
     */
    public function withRequiredKeywords(array $requiredKeywords): self
    {
        $self = clone $this;
        $self['requiredKeywords'] = $requiredKeywords;

        return $self;
    }

    /**
     * @param list<string> $requiredMentions
     */
    public function withRequiredMentions(array $requiredMentions): self
    {
        $self = clone $this;
        $self['requiredMentions'] = $requiredMentions;

        return $self;
    }

    public function withUniqueAuthorsOnly(bool $uniqueAuthorsOnly): self
    {
        $self = clone $this;
        $self['uniqueAuthorsOnly'] = $uniqueAuthorsOnly;

        return $self;
    }

    public function withWinnerCount(int $winnerCount): self
    {
        $self = clone $this;
        $self['winnerCount'] = $winnerCount;

        return $self;
    }
}
