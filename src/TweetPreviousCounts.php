<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetPreviousCountsShape = array{
 *   bookmarkCount?: int|null,
 *   likeCount?: int|null,
 *   quoteCount?: int|null,
 *   replyCount?: int|null,
 *   retweetCount?: int|null,
 * }
 */
final class TweetPreviousCounts implements BaseModel
{
    /** @use SdkModel<TweetPreviousCountsShape> */
    use SdkModel;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $bookmarkCount;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $likeCount;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $quoteCount;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $replyCount;

    /**
     * Whole number from 0.
     */
    #[Optional]
    public ?int $retweetCount;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?int $bookmarkCount = null, ?int $likeCount = null, ?int $quoteCount = null, ?int $replyCount = null, ?int $retweetCount = null): self
    {
        $self = new self;

        null !== $bookmarkCount && $self['bookmarkCount'] = $bookmarkCount;
        null !== $likeCount && $self['likeCount'] = $likeCount;
        null !== $quoteCount && $self['quoteCount'] = $quoteCount;
        null !== $replyCount && $self['replyCount'] = $replyCount;
        null !== $retweetCount && $self['retweetCount'] = $retweetCount;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withBookmarkCount(?int $bookmarkCount): self
    {
        $self = clone $this;
        $self['bookmarkCount'] = $bookmarkCount;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withLikeCount(?int $likeCount): self
    {
        $self = clone $this;
        $self['likeCount'] = $likeCount;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withQuoteCount(?int $quoteCount): self
    {
        $self = clone $this;
        $self['quoteCount'] = $quoteCount;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withReplyCount(?int $replyCount): self
    {
        $self = clone $this;
        $self['replyCount'] = $replyCount;

        return $self;
    }

    /**
     * Whole number from 0.
     */
    public function withRetweetCount(?int $retweetCount): self
    {
        $self = clone $this;
        $self['retweetCount'] = $retweetCount;

        return $self;
    }
}
