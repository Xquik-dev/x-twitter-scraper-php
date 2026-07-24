<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List users who retweeted a tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getRetweeters()
 *
 * @phpstan-type TweetGetRetweetersParamsShape = array{
 *   cursor?: string|null, pageSize?: int|null
 * }
 */
final class TweetGetRetweetersParams implements BaseModel
{
    /** @use SdkModel<TweetGetRetweetersParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for retweeters.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     */
    #[Optional]
    public ?int $pageSize;

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
        ?string $cursor = null,
        ?int $pageSize = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Pagination cursor for retweeters.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Maximum user profiles requested from this page (20-200, default 200). The response can contain fewer profiles because the source returned fewer or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true. The deprecated limit and count aliases remain accepted.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }
}
