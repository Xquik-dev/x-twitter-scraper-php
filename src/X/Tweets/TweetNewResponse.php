<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetNewResponseShape = array{success: bool, tweetID: string}
 */
final class TweetNewResponse implements BaseModel
{
    /** @use SdkModel<TweetNewResponseShape> */
    use SdkModel;

    #[Required]
    public bool $success = true;

    #[Required('tweetId')]
    public string $tweetID;

    /**
     * `new TweetNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetNewResponse::with(tweetID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetNewResponse)->withTweetID(...)
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
    public static function with(string $tweetID): self
    {
        $self = new self;

        $self['tweetID'] = $tweetID;

        return $self;
    }

    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    public function withTweetID(string $tweetID): self
    {
        $self = clone $this;
        $self['tweetID'] = $tweetID;

        return $self;
    }
}
