<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get users who liked a tweet.
 *
 * @see XTwitterScraper\Services\X\TweetsService::getFavoriters()
 *
 * @phpstan-type TweetGetFavoritersParamsShape = array{cursor?: string|null}
 */
final class TweetGetFavoritersParams implements BaseModel
{
    /** @use SdkModel<TweetGetFavoritersParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for favoriters.
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
     * Pagination cursor for favoriters.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
