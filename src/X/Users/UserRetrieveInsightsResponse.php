<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Users;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\UserInsights;

/**
 * @phpstan-type UserRetrieveInsightsResponseShape = array{
 *   insights: UserInsights|array<string,mixed>,
 *   message?: string|null,
 * }
 */
final class UserRetrieveInsightsResponse implements BaseModel
{
    /** @use SdkModel<UserRetrieveInsightsResponseShape> */
    use SdkModel;

    /**
     * Engagement insights of 1 profile. Engagements are likes, replies, reposts and quotes. A rate is null when nothing divides it, such as a profile without posts of its own.
     */
    #[Required]
    public UserInsights $insights;

    /**
     * Says why the report has counts only. Sent only when postsPrivate is true.
     */
    #[Optional]
    public ?string $message;

    /**
     * `new UserRetrieveInsightsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserRetrieveInsightsResponse::with(insights: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserRetrieveInsightsResponse)->withInsights(...)
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
     * @param UserInsights|array<string,mixed> $insights
     */
    public static function with(UserInsights|array $insights, ?string $message = null): self
    {
        $self = new self;

        $self['insights'] = $insights;

        null !== $message && $self['message'] = $message;

        return $self;
    }

    /**
     * Engagement insights of 1 profile. Engagements are likes, replies, reposts and quotes. A rate is null when nothing divides it, such as a profile without posts of its own.
     *
     * @param UserInsights|array<string,mixed> $insights
     */
    public function withInsights(UserInsights|array $insights): self
    {
        $self = clone $this;
        $self['insights'] = $insights;

        return $self;
    }

    /**
     * Says why the report has counts only. Sent only when postsPrivate is true.
     */
    public function withMessage(?string $message): self
    {
        $self = clone $this;
        $self['message'] = $message;

        return $self;
    }
}
