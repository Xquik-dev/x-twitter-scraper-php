<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetInsightsShape = array{
 *   tweetID: string,
 *   authorID: string|null,
 *   authorUserName: string|null,
 *   createdAt: \DateTimeInterface|null,
 *   ageHours: float|null,
 *   metrics: PostEngagementMetrics|array<string,mixed>,
 *   engagements: float,
 *   engagementsPerHour: float|null,
 *   engagementPerView: float|null,
 *   engagementRate: float|null,
 *   amplification: float|null,
 *   conversation: float|null,
 * }
 */
final class TweetInsights implements BaseModel
{
    /** @use SdkModel<TweetInsightsShape> */
    use SdkModel;

    /**
     * ID of the tweet the insights describe.
     */
    #[Required('tweetId')]
    public string $tweetID;

    /**
     * ID of the author.
     */
    #[Required('authorId')]
    public ?string $authorID;

    /**
     * Username of the author.
     */
    #[Required]
    public ?string $authorUserName;

    /**
     * When the tweet went up.
     */
    #[Required]
    public ?\DateTimeInterface $createdAt;

    /**
     * Hours since the tweet went up.
     */
    #[Required]
    public ?float $ageHours;

    /**
     * The public counts of 1 tweet.
     */
    #[Required]
    public PostEngagementMetrics $metrics;

    /**
     * Likes, replies, reposts and quotes.
     */
    #[Required]
    public float $engagements;

    /**
     * Engagements per hour since the tweet went up.
     */
    #[Required]
    public ?float $engagementsPerHour;

    /**
     * Engagements as a percent of views.
     */
    #[Required]
    public ?float $engagementPerView;

    /**
     * Engagements as a percent of the author's followers.
     */
    #[Required]
    public ?float $engagementRate;

    /**
     * Reposts and quotes per like.
     */
    #[Required]
    public ?float $amplification;

    /**
     * Replies per like.
     */
    #[Required]
    public ?float $conversation;

    /**
     * `new TweetInsights()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetInsights::with(tweetID: ..., authorID: ..., authorUserName: ..., createdAt: ..., ageHours: ..., metrics: ..., engagements: ..., engagementsPerHour: ..., engagementPerView: ..., engagementRate: ..., amplification: ..., conversation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetInsights)->withTweetID(...)->withAuthorID(...)->withAuthorUserName(...)->withCreatedAt(...)->withAgeHours(...)->withMetrics(...)->withEngagements(...)->withEngagementsPerHour(...)->withEngagementPerView(...)->withEngagementRate(...)->withAmplification(...)->withConversation(...)
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
     * @param PostEngagementMetrics|array<string,mixed> $metrics
     */
    public static function with(string $tweetID, ?string $authorID, ?string $authorUserName, ?\DateTimeInterface $createdAt, ?float $ageHours, PostEngagementMetrics|array $metrics, float $engagements, ?float $engagementsPerHour, ?float $engagementPerView, ?float $engagementRate, ?float $amplification, ?float $conversation): self
    {
        $self = new self;

        $self['tweetID'] = $tweetID;
        $self['authorID'] = $authorID;
        $self['authorUserName'] = $authorUserName;
        $self['createdAt'] = $createdAt;
        $self['ageHours'] = $ageHours;
        $self['metrics'] = $metrics;
        $self['engagements'] = $engagements;
        $self['engagementsPerHour'] = $engagementsPerHour;
        $self['engagementPerView'] = $engagementPerView;
        $self['engagementRate'] = $engagementRate;
        $self['amplification'] = $amplification;
        $self['conversation'] = $conversation;

        return $self;
    }

    /**
     * ID of the tweet the insights describe.
     */
    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    /**
     * ID of the author.
     */
    public function withAuthorID(?string $authorID): self
    {
        $self = clone $this;
        $self['authorID'] = $authorID;

        return $self;
    }

    /**
     * Username of the author.
     */
    public function withAuthorUserName(?string $authorUserName): self
    {
        $self = clone $this;
        $self['authorUserName'] = $authorUserName;

        return $self;
    }

    /**
     * When the tweet went up.
     */
    public function withCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Hours since the tweet went up.
     */
    public function withAgeHours(?float $ageHours): self
    {
        $self = clone $this;
        $self['ageHours'] = $ageHours;

        return $self;
    }

    /**
     * The public counts of 1 tweet.
     *
     * @param PostEngagementMetrics|array<string,mixed> $metrics
     */
    public function withMetrics(PostEngagementMetrics|array $metrics): self
    {
        $self = clone $this;
        $self['metrics'] = $metrics;

        return $self;
    }

    /**
     * Likes, replies, reposts and quotes.
     */
    public function withEngagements(float $engagements): self
    {
        $self = clone $this;
        $self['engagements'] = $engagements;

        return $self;
    }

    /**
     * Engagements per hour since the tweet went up.
     */
    public function withEngagementsPerHour(?float $engagementsPerHour): self
    {
        $self = clone $this;
        $self['engagementsPerHour'] = $engagementsPerHour;

        return $self;
    }

    /**
     * Engagements as a percent of views.
     */
    public function withEngagementPerView(?float $engagementPerView): self
    {
        $self = clone $this;
        $self['engagementPerView'] = $engagementPerView;

        return $self;
    }

    /**
     * Engagements as a percent of the author's followers.
     */
    public function withEngagementRate(?float $engagementRate): self
    {
        $self = clone $this;
        $self['engagementRate'] = $engagementRate;

        return $self;
    }

    /**
     * Reposts and quotes per like.
     */
    public function withAmplification(?float $amplification): self
    {
        $self = clone $this;
        $self['amplification'] = $amplification;

        return $self;
    }

    /**
     * Replies per like.
     */
    public function withConversation(?float $conversation): self
    {
        $self = clone $this;
        $self['conversation'] = $conversation;

        return $self;
    }
}
