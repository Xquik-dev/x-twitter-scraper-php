<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Styles\StyleGetPerformanceResponse\Tweet;

/**
 * @phpstan-import-type TweetShape from \XTwitterScraper\Styles\StyleGetPerformanceResponse\Tweet
 *
 * @phpstan-type StyleGetPerformanceResponseShape = array{
 *   tweetCount: int, tweets: list<Tweet|TweetShape>, xUsername: string
 * }
 */
final class StyleGetPerformanceResponse implements BaseModel
{
    /** @use SdkModel<StyleGetPerformanceResponseShape> */
    use SdkModel;

    #[Required]
    public int $tweetCount;

    /** @var list<Tweet> $tweets */
    #[Required(list: Tweet::class)]
    public array $tweets;

    #[Required]
    public string $xUsername;

    /**
     * `new StyleGetPerformanceResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleGetPerformanceResponse::with(tweetCount: ..., tweets: ..., xUsername: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleGetPerformanceResponse)
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
        int $tweetCount,
        array $tweets,
        string $xUsername
    ): self {
        $self = new self;

        $self['tweetCount'] = $tweetCount;
        $self['tweets'] = $tweets;
        $self['xUsername'] = $xUsername;

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
