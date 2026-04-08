<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Full giveaway draw with tweet metrics, entries, and timing.
 *
 * @phpstan-type DrawDetailShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   status: string,
 *   totalEntries: int,
 *   tweetAuthorUsername: string,
 *   tweetID: string,
 *   tweetLikeCount: int,
 *   tweetQuoteCount: int,
 *   tweetReplyCount: int,
 *   tweetRetweetCount: int,
 *   tweetText: string,
 *   tweetURL: string,
 *   validEntries: int,
 *   drawnAt?: \DateTimeInterface|null,
 * }
 */
final class DrawDetail implements BaseModel
{
    /** @use SdkModel<DrawDetailShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $status;

    #[Required]
    public int $totalEntries;

    #[Required]
    public string $tweetAuthorUsername;

    #[Required('tweetId')]
    public string $tweetID;

    #[Required]
    public int $tweetLikeCount;

    #[Required]
    public int $tweetQuoteCount;

    #[Required]
    public int $tweetReplyCount;

    #[Required]
    public int $tweetRetweetCount;

    #[Required]
    public string $tweetText;

    #[Required('tweetUrl')]
    public string $tweetURL;

    #[Required]
    public int $validEntries;

    #[Optional]
    public ?\DateTimeInterface $drawnAt;

    /**
     * `new DrawDetail()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DrawDetail::with(
     *   id: ...,
     *   createdAt: ...,
     *   status: ...,
     *   totalEntries: ...,
     *   tweetAuthorUsername: ...,
     *   tweetID: ...,
     *   tweetLikeCount: ...,
     *   tweetQuoteCount: ...,
     *   tweetReplyCount: ...,
     *   tweetRetweetCount: ...,
     *   tweetText: ...,
     *   tweetURL: ...,
     *   validEntries: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DrawDetail)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withStatus(...)
     *   ->withTotalEntries(...)
     *   ->withTweetAuthorUsername(...)
     *   ->withTweetID(...)
     *   ->withTweetLikeCount(...)
     *   ->withTweetQuoteCount(...)
     *   ->withTweetReplyCount(...)
     *   ->withTweetRetweetCount(...)
     *   ->withTweetText(...)
     *   ->withTweetURL(...)
     *   ->withValidEntries(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $status,
        int $totalEntries,
        string $tweetAuthorUsername,
        string $tweetID,
        int $tweetLikeCount,
        int $tweetQuoteCount,
        int $tweetReplyCount,
        int $tweetRetweetCount,
        string $tweetText,
        string $tweetURL,
        int $validEntries,
        ?\DateTimeInterface $drawnAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['status'] = $status;
        $self['totalEntries'] = $totalEntries;
        $self['tweetAuthorUsername'] = $tweetAuthorUsername;
        $self['tweetID'] = $tweetID;
        $self['tweetLikeCount'] = $tweetLikeCount;
        $self['tweetQuoteCount'] = $tweetQuoteCount;
        $self['tweetReplyCount'] = $tweetReplyCount;
        $self['tweetRetweetCount'] = $tweetRetweetCount;
        $self['tweetText'] = $tweetText;
        $self['tweetURL'] = $tweetURL;
        $self['validEntries'] = $validEntries;

        null !== $drawnAt && $self['drawnAt'] = $drawnAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withTotalEntries(int $totalEntries): self
    {
        $self = clone $this;
        $self['totalEntries'] = $totalEntries;

        return $self;
    }

    public function withTweetAuthorUsername(string $tweetAuthorUsername): self
    {
        $self = clone $this;
        $self['tweetAuthorUsername'] = $tweetAuthorUsername;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withTweetLikeCount(int $tweetLikeCount): self
    {
        $self = clone $this;
        $self['tweetLikeCount'] = $tweetLikeCount;

        return $self;
    }

    public function withTweetQuoteCount(int $tweetQuoteCount): self
    {
        $self = clone $this;
        $self['tweetQuoteCount'] = $tweetQuoteCount;

        return $self;
    }

    public function withTweetReplyCount(int $tweetReplyCount): self
    {
        $self = clone $this;
        $self['tweetReplyCount'] = $tweetReplyCount;

        return $self;
    }

    public function withTweetRetweetCount(int $tweetRetweetCount): self
    {
        $self = clone $this;
        $self['tweetRetweetCount'] = $tweetRetweetCount;

        return $self;
    }

    public function withTweetText(string $tweetText): self
    {
        $self = clone $this;
        $self['tweetText'] = $tweetText;

        return $self;
    }

    public function withTweetURL(string $tweetURL): self
    {
        $self = clone $this;
        $self['tweetURL'] = $tweetURL;

        return $self;
    }

    public function withValidEntries(int $validEntries): self
    {
        $self = clone $this;
        $self['validEntries'] = $validEntries;

        return $self;
    }

    public function withDrawnAt(\DateTimeInterface $drawnAt): self
    {
        $self = clone $this;
        $self['drawnAt'] = $drawnAt;

        return $self;
    }
}
