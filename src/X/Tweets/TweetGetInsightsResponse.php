<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\TweetInsights;

/**
 * @phpstan-type TweetGetInsightsResponseShape = array{
 *   insights: TweetInsights|array<string,mixed>,
 * }
 */
final class TweetGetInsightsResponse implements BaseModel
{
    /** @use SdkModel<TweetGetInsightsResponseShape> */
    use SdkModel;

    /**
     * Engagement insights of 1 tweet. Engagements are likes, replies, reposts and quotes. A rate is null when nothing divides it, such as a tweet without views.
     */
    #[Required]
    public TweetInsights $insights;

    /**
     * `new TweetGetInsightsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetGetInsightsResponse::with(insights: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetGetInsightsResponse)->withInsights(...)
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
     * @param TweetInsights|array<string,mixed> $insights
     */
    public static function with(TweetInsights|array $insights): self
    {
        $self = new self;

        $self['insights'] = $insights;

        return $self;
    }

    /**
     * Engagement insights of 1 tweet. Engagements are likes, replies, reposts and quotes. A rate is null when nothing divides it, such as a tweet without views.
     *
     * @param TweetInsights|array<string,mixed> $insights
     */
    public function withInsights(TweetInsights|array $insights): self
    {
        $self = clone $this;
        $self['insights'] = $insights;

        return $self;
    }
}
