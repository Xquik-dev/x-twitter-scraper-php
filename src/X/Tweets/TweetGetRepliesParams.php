<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get replies to a tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getReplies()
 *
 * @phpstan-type TweetGetRepliesParamsShape = array{
 *   cursor?: string|null, sinceTime?: string|null, untilTime?: string|null
 * }
 */
final class TweetGetRepliesParams implements BaseModel
{
    /** @use SdkModel<TweetGetRepliesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for tweet replies.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Unix timestamp - return replies posted after this time.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * Unix timestamp - return replies posted before this time.
     */
    #[Optional]
    public ?string $untilTime;

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
        ?string $sinceTime = null,
        ?string $untilTime = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $untilTime && $self['untilTime'] = $untilTime;

        return $self;
    }

    /**
     * Pagination cursor for tweet replies.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Unix timestamp - return replies posted after this time.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Unix timestamp - return replies posted before this time.
     */
    public function withUntilTime(string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }
}
