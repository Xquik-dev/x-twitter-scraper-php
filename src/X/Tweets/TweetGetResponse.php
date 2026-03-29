<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetGetResponse\Author;
use XTwitterScraper\X\Tweets\TweetGetResponse\Tweet;

/**
 * @phpstan-import-type TweetShape from \XTwitterScraper\X\Tweets\TweetGetResponse\Tweet
 * @phpstan-import-type AuthorShape from \XTwitterScraper\X\Tweets\TweetGetResponse\Author
 *
 * @phpstan-type TweetGetResponseShape = array{
 *   tweet: Tweet|TweetShape, author?: null|Author|AuthorShape
 * }
 */
final class TweetGetResponse implements BaseModel
{
    /** @use SdkModel<TweetGetResponseShape> */
    use SdkModel;

    #[Required]
    public Tweet $tweet;

    #[Optional]
    public ?Author $author;

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
     * @param Tweet|TweetShape $tweet
     * @param Author|AuthorShape|null $author
     */
    public static function with(
        Tweet|array $tweet,
        Author|array|null $author = null
    ): self {
        $self = new self;

        $self['tweet'] = $tweet;

        null !== $author && $self['author'] = $author;

        return $self;
    }

    /**
     * @param Tweet|TweetShape $tweet
     */
    public function withTweet(Tweet|array $tweet): self
    {
        $self = clone $this;
        $self['tweet'] = $tweet;

        return $self;
    }

    /**
     * @param Author|AuthorShape $author
     */
    public function withAuthor(Author|array $author): self
    {
        $self = clone $this;
        $self['author'] = $author;

        return $self;
    }
}
