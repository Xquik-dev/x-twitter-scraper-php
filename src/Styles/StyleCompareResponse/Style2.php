<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles\StyleCompareResponse;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Styles\StyleCompareResponse\Style2\Tweet;

/**
 * @phpstan-import-type TweetShape from \XTwitterScraper\Styles\StyleCompareResponse\Style2\Tweet
 *
 * @phpstan-type Style2Shape = array{
 *   fetchedAt: \DateTimeInterface,
 *   isOwnAccount: bool,
 *   tweetCount: int,
 *   tweets: list<Tweet|TweetShape>,
 *   xUsername: string,
 * }
 */
final class Style2 implements BaseModel
{
    /** @use SdkModel<Style2Shape> */
    use SdkModel;

    #[Required]
    public \DateTimeInterface $fetchedAt;

    #[Required]
    public bool $isOwnAccount;

    #[Required]
    public int $tweetCount;

    /** @var list<Tweet> $tweets */
    #[Required(list: Tweet::class)]
    public array $tweets;

    #[Required]
    public string $xUsername;

    /**
     * `new Style2()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Style2::with(
     *   fetchedAt: ...,
     *   isOwnAccount: ...,
     *   tweetCount: ...,
     *   tweets: ...,
     *   xUsername: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Style2)
     *   ->withFetchedAt(...)
     *   ->withIsOwnAccount(...)
     *   ->withTweetCount(...)
     *   ->withTweets(...)
     *   ->withXUsername(...)
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
     * @param list<Tweet|TweetShape> $tweets
     */
    public static function with(
        \DateTimeInterface $fetchedAt,
        bool $isOwnAccount,
        int $tweetCount,
        array $tweets,
        string $xUsername,
    ): self {
        $self = new self;

        $self['fetchedAt'] = $fetchedAt;
        $self['isOwnAccount'] = $isOwnAccount;
        $self['tweetCount'] = $tweetCount;
        $self['tweets'] = $tweets;
        $self['xUsername'] = $xUsername;

        return $self;
    }

    public function withFetchedAt(\DateTimeInterface $fetchedAt): self
    {
        $self = clone $this;
        $self['fetchedAt'] = $fetchedAt;

        return $self;
    }

    public function withIsOwnAccount(bool $isOwnAccount): self
    {
        $self = clone $this;
        $self['isOwnAccount'] = $isOwnAccount;

        return $self;
    }

    public function withTweetCount(int $tweetCount): self
    {
        $self = clone $this;
        $self['tweetCount'] = $tweetCount;

        return $self;
    }

    /**
     * @param list<Tweet|TweetShape> $tweets
     */
    public function withTweets(array $tweets): self
    {
        $self = clone $this;
        $self['tweets'] = $tweets;

        return $self;
    }

    public function withXUsername(string $xUsername): self
    {
        $self = clone $this;
        $self['xUsername'] = $xUsername;

        return $self;
    }
}
