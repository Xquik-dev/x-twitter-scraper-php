<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetCheckRepostResponseShape = array{
 *   isRetweeted: bool,
 *   retweetedAt: \DateTimeInterface|null,
 *   retweetID: string|null,
 *   tweetID: string,
 *   userID: string,
 *   checkedPosts: int,
 *   complete: bool,
 * }
 */
final class TweetCheckRepostResponse implements BaseModel
{
    /** @use SdkModel<TweetCheckRepostResponseShape> */
    use SdkModel;

    /**
     * Whether the account reposted the post.
     */
    #[Required]
    public bool $isRetweeted;

    /**
     * When the account reposted it, else null.
     */
    #[Required]
    public ?\DateTimeInterface $retweetedAt;

    /**
     * The ID of the account's repost, else null.
     */
    #[Required('retweetId')]
    public ?string $retweetID;

    #[Required('tweetId')]
    public string $tweetID;

    #[Required('userId')]
    public string $userID;

    /**
     * How many of the account's newest posts the check read.
     */
    #[Required]
    public int $checkedPosts;

    /**
     * Whether the check read the account's whole timeline.
     */
    #[Required]
    public bool $complete;

    /**
     * `new TweetCheckRepostResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetCheckRepostResponse::with(isRetweeted: ..., retweetedAt: ..., retweetID: ..., tweetID: ..., userID: ..., checkedPosts: ..., complete: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetCheckRepostResponse)->withIsRetweeted(...)->withRetweetedAt(...)->withRetweetID(...)->withTweetID(...)->withUserID(...)->withCheckedPosts(...)->withComplete(...)
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
     */
    public static function with(bool $isRetweeted, ?\DateTimeInterface $retweetedAt, ?string $retweetID, string $tweetID, string $userID, int $checkedPosts, bool $complete): self
    {
        $self = new self;

        $self['isRetweeted'] = $isRetweeted;
        $self['retweetedAt'] = $retweetedAt;
        $self['retweetID'] = $retweetID;
        $self['tweetID'] = $tweetID;
        $self['userID'] = $userID;
        $self['checkedPosts'] = $checkedPosts;
        $self['complete'] = $complete;

        return $self;
    }

    /**
     * Whether the account reposted the post.
     */
    public function withIsRetweeted(bool $isRetweeted): self
    {
        $self = clone $this;
        $self['isRetweeted'] = $isRetweeted;

        return $self;
    }

    /**
     * When the account reposted it, else null.
     */
    public function withRetweetedAt(?\DateTimeInterface $retweetedAt): self
    {
        $self = clone $this;
        $self['retweetedAt'] = $retweetedAt;

        return $self;
    }

    /**
     * The ID of the account's repost, else null.
     */
    public function withRetweetID(?string $retweetID): self
    {
        $self = clone $this;
        $self['retweetID'] = $retweetID;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * How many of the account's newest posts the check read.
     */
    public function withCheckedPosts(int $checkedPosts): self
    {
        $self = clone $this;
        $self['checkedPosts'] = $checkedPosts;

        return $self;
    }

    /**
     * Whether the check read the account's whole timeline.
     */
    public function withComplete(bool $complete): self
    {
        $self = clone $this;
        $self['complete'] = $complete;

        return $self;
    }
}
