<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get quote tweets of a tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getQuotes()
 *
 * @phpstan-type TweetGetQuotesParamsShape = array{
 *   cursor?: string|null,
 *   includeReplies?: bool|null,
 *   sinceTime?: string|null,
 *   untilTime?: string|null,
 * }
 */
final class TweetGetQuotesParams implements BaseModel
{
    /** @use SdkModel<TweetGetQuotesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for quote tweets.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Include reply quotes (default false).
     */
    #[Optional]
    public ?bool $includeReplies;

    /**
     * Unix timestamp - return quotes posted after this time.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * Unix timestamp - return quotes posted before this time.
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
        ?bool $includeReplies = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $includeReplies && $self['includeReplies'] = $includeReplies;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $untilTime && $self['untilTime'] = $untilTime;

        return $self;
    }

    /**
     * Pagination cursor for quote tweets.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Include reply quotes (default false).
     */
    public function withIncludeReplies(bool $includeReplies): self
    {
        $self = clone $this;
        $self['includeReplies'] = $includeReplies;

        return $self;
    }

    /**
     * Unix timestamp - return quotes posted after this time.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Unix timestamp - return quotes posted before this time.
     */
    public function withUntilTime(string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }
}
