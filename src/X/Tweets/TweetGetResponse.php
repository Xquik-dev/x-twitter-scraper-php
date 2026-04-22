<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TweetDetailShape from \XTwitterScraper\X\Tweets\TweetDetail
 * @phpstan-import-type TweetAuthorShape from \XTwitterScraper\X\Tweets\TweetAuthor
 *
 * @phpstan-type TweetGetResponseShape = array{
 *   tweet: TweetDetail|TweetDetailShape,
 *   author?: null|TweetAuthor|TweetAuthorShape,
 * }
 */
final class TweetGetResponse implements BaseModel
{
    /** @use SdkModel<TweetGetResponseShape> */
    use SdkModel;

    /**
     * Full tweet with text, engagement metrics, media, and metadata.
     */
    #[Required]
    public TweetDetail $tweet;

    /**
     * Author of a tweet with follower count and verification status.
     */
    #[Optional]
    public ?TweetAuthor $author;

    /**
     * `new TweetGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetGetResponse::with(tweet: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetGetResponse)->withTweet(...)
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
     * @param TweetDetail|TweetDetailShape $tweet
     * @param TweetAuthor|TweetAuthorShape|null $author
     */
    public static function with(
        TweetDetail|array $tweet,
        TweetAuthor|array|null $author = null
    ): self {
        $self = new self;

        $self['tweet'] = $tweet;

        null !== $author && $self['author'] = $author;

        return $self;
    }

    /**
     * Full tweet with text, engagement metrics, media, and metadata.
     *
     * @param TweetDetail|TweetDetailShape $tweet
     */
    public function withTweet(TweetDetail|array $tweet): self
    {
        $self = clone $this;
        $self['tweet'] = $tweet;

        return $self;
    }

    /**
     * Author of a tweet with follower count and verification status.
     *
     * @param TweetAuthor|TweetAuthorShape $author
     */
    public function withAuthor(TweetAuthor|array $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }
}
