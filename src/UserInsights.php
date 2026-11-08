<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\UserInsights\Averages;
use XTwitterScraper\UserInsights\Sample;

/**
 * @phpstan-type UserInsightsShape = array{
 *   userID: string,
 *   userName: string,
 *   followers: float,
 *   following: float,
 *   posts: float,
 *   accountAgeDays: float|null,
 *   postsPrivate: bool,
 *   sample: Sample|array<string,mixed>,
 *   averages: Averages|array<string,mixed>|null,
 *   medianViews: float|null,
 *   engagementRate: float|null,
 *   engagementPerView: float|null,
 *   postsPerDay: float|null,
 *   topPostID: string|null,
 * }
 */
final class UserInsights implements BaseModel
{
    /** @use SdkModel<UserInsightsShape> */
    use SdkModel;

    /**
     * ID of the profile the insights describe.
     */
    #[Required('userId')]
    public string $userID;

    /**
     * Username of that profile.
     */
    #[Required]
    public string $userName;

    /**
     * Followers.
     */
    #[Required]
    public float $followers;

    /**
     * Accounts the user follows.
     */
    #[Required]
    public float $following;

    /**
     * Posts the user has made.
     */
    #[Required]
    public float $posts;

    /**
     * Whole days since the account joined X.
     */
    #[Required]
    public ?float $accountAgeDays;

    /**
     * True when only the account's followers see its posts. The report then has its counts only.
     */
    #[Required]
    public bool $postsPrivate;

    /**
     * The recent posts the read covered.
     */
    #[Required]
    public Sample $sample;

    /**
     * Each count per post of the sample. Null without posts.
     */
    #[Required]
    public ?Averages $averages;

    /**
     * Middle view count of the sample, so 1 viral post moves it less than the average. Null without posts.
     */
    #[Required]
    public ?float $medianViews;

    /**
     * Average engagements per post, as a percent of followers.
     */
    #[Required]
    public ?float $engagementRate;

    /**
     * Engagements as a percent of views across the sample.
     */
    #[Required]
    public ?float $engagementPerView;

    /**
     * Sampled posts per day, from the oldest one until now.
     */
    #[Required]
    public ?float $postsPerDay;

    /**
     * The sampled post with the most engagements.
     */
    #[Required('topPostId')]
    public ?string $topPostID;

    /**
     * `new UserInsights()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserInsights::with(userID: ..., userName: ..., followers: ..., following: ..., posts: ..., accountAgeDays: ..., postsPrivate: ..., sample: ..., averages: ..., medianViews: ..., engagementRate: ..., engagementPerView: ..., postsPerDay: ..., topPostID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserInsights)->withUserID(...)->withUserName(...)->withFollowers(...)->withFollowing(...)->withPosts(...)->withAccountAgeDays(...)->withPostsPrivate(...)->withSample(...)->withAverages(...)->withMedianViews(...)->withEngagementRate(...)->withEngagementPerView(...)->withPostsPerDay(...)->withTopPostID(...)
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
     * @param Sample|array<string,mixed> $sample
     * @param Averages|array<string,mixed>|null $averages
     */
    public static function with(string $userID, string $userName, float $followers, float $following, float $posts, ?float $accountAgeDays, bool $postsPrivate, Sample|array $sample, Averages|array|null $averages, ?float $medianViews, ?float $engagementRate, ?float $engagementPerView, ?float $postsPerDay, ?string $topPostID): self
    {
        $self = new self;

        $self['userID'] = $userID;
        $self['userName'] = $userName;
        $self['followers'] = $followers;
        $self['following'] = $following;
        $self['posts'] = $posts;
        $self['accountAgeDays'] = $accountAgeDays;
        $self['postsPrivate'] = $postsPrivate;
        $self['sample'] = $sample;
        $self['averages'] = $averages;
        $self['medianViews'] = $medianViews;
        $self['engagementRate'] = $engagementRate;
        $self['engagementPerView'] = $engagementPerView;
        $self['postsPerDay'] = $postsPerDay;
        $self['topPostID'] = $topPostID;

        return $self;
    }

    /**
     * ID of the profile the insights describe.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * Username of that profile.
     */
    public function withUserName(string $userName): self
    {
        $self = clone $this;
        $self['userName'] = $userName;

        return $self;
    }

    /**
     * Followers.
     */
    public function withFollowers(float $followers): self
    {
        $self = clone $this;
        $self['followers'] = $followers;

        return $self;
    }

    /**
     * Accounts the user follows.
     */
    public function withFollowing(float $following): self
    {
        $self = clone $this;
        $self['following'] = $following;

        return $self;
    }

    /**
     * Posts the user has made.
     */
    public function withPosts(float $posts): self
    {
        $self = clone $this;
        $self['posts'] = $posts;

        return $self;
    }

    /**
     * Whole days since the account joined X.
     */
    public function withAccountAgeDays(?float $accountAgeDays): self
    {
        $self = clone $this;
        $self['accountAgeDays'] = $accountAgeDays;

        return $self;
    }

    /**
     * True when only the account's followers see its posts. The report then has its counts only.
     */
    public function withPostsPrivate(bool $postsPrivate): self
    {
        $self = clone $this;
        $self['postsPrivate'] = $postsPrivate;

        return $self;
    }

    /**
     * The recent posts the read covered.
     *
     * @param Sample|array<string,mixed> $sample
     */
    public function withSample(Sample|array $sample): self
    {
        $self = clone $this;
        $self['sample'] = $sample;

        return $self;
    }

    /**
     * Each count per post of the sample. Null without posts.
     *
     * @param Averages|array<string,mixed>|null $averages
     */
    public function withAverages(Averages|array|null $averages): self
    {
        $self = clone $this;
        $self['averages'] = $averages;

        return $self;
    }

    /**
     * Middle view count of the sample, so 1 viral post moves it less than the average. Null without posts.
     */
    public function withMedianViews(?float $medianViews): self
    {
        $self = clone $this;
        $self['medianViews'] = $medianViews;

        return $self;
    }

    /**
     * Average engagements per post, as a percent of followers.
     */
    public function withEngagementRate(?float $engagementRate): self
    {
        $self = clone $this;
        $self['engagementRate'] = $engagementRate;

        return $self;
    }

    /**
     * Engagements as a percent of views across the sample.
     */
    public function withEngagementPerView(?float $engagementPerView): self
    {
        $self = clone $this;
        $self['engagementPerView'] = $engagementPerView;

        return $self;
    }

    /**
     * Sampled posts per day, from the oldest one until now.
     */
    public function withPostsPerDay(?float $postsPerDay): self
    {
        $self = clone $this;
        $self['postsPerDay'] = $postsPerDay;

        return $self;
    }

    /**
     * The sampled post with the most engagements.
     */
    public function withTopPostID(?string $topPostID): self
    {
        $self = clone $this;
        $self['topPostID'] = $topPostID;

        return $self;
    }
}
