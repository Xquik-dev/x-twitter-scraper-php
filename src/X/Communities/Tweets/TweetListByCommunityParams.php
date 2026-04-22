<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get community tweets.
 *
 * @see XTwitterScraper\Services\X\Communities\TweetsService::listByCommunity()
 *
 * @phpstan-type TweetListByCommunityParamsShape = array{cursor?: string|null}
 */
final class TweetListByCommunityParams implements BaseModel
{
    /** @use SdkModel<TweetListByCommunityParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for community tweets.
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
     * Pagination cursor for community tweets.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }
}
