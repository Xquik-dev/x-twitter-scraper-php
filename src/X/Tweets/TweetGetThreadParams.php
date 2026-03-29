<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get thread context for a tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getThread()
 *
 * @phpstan-type TweetGetThreadParamsShape = array{cursor?: string|null}
 */
final class TweetGetThreadParams implements BaseModel
{
    /** @use SdkModel<TweetGetThreadParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor.
     */
    #[Optional]
    public ?string $cursor;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $cursor = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Pagination cursor.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
