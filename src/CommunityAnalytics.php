<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\CommunityAnalytics\Metrics;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type CommunityAnalyticsShape = array{
 *   id: string,
 *   periodEndsAt: \DateTimeInterface,
 *   metrics: Metrics|array<string,mixed>,
 * }
 */
final class CommunityAnalytics implements BaseModel
{
    /** @use SdkModel<CommunityAnalyticsShape> */
    use SdkModel;

    /**
     * The community ID from your request.
     */
    #[Required]
    public string $id;

    /**
     * The end of X's latest period, in UTC.
     */
    #[Required]
    public \DateTimeInterface $periodEndsAt;

    /**
     * The period's activity, each metric with its count and changePercent. likes counts likes on community posts and newMembers the accounts that joined. posts counts the community posts and replies the replies to them. uniquePosters counts the distinct accounts that posted.
     */
    #[Required]
    public Metrics $metrics;

    /**
     * `new CommunityAnalytics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityAnalytics::with(id: ..., periodEndsAt: ..., metrics: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityAnalytics)->withId(...)->withPeriodEndsAt(...)->withMetrics(...)
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
     * @param Metrics|array<string,mixed> $metrics
     */
    public static function with(string $id, \DateTimeInterface $periodEndsAt, Metrics|array $metrics): self
    {
        $self = new self;

        $self['id'] = $id;
        $self['periodEndsAt'] = $periodEndsAt;
        $self['metrics'] = $metrics;

        return $self;
    }

    /**
     * The community ID from your request.
     */
    public function withId(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * The end of X's latest period, in UTC.
     */
    public function withPeriodEndsAt(\DateTimeInterface $periodEndsAt): self
    {
        $self = clone $this;
        $self['periodEndsAt'] = $periodEndsAt;

        return $self;
    }

    /**
     * The period's activity, each metric with its count and changePercent. likes counts likes on community posts and newMembers the accounts that joined. posts counts the community posts and replies the replies to them. uniquePosters counts the distinct accounts that posted.
     *
     * @param Metrics|array<string,mixed> $metrics
     */
    public function withMetrics(Metrics|array $metrics): self
    {
        $self = clone $this;
        $self['metrics'] = $metrics;

        return $self;
    }
}
