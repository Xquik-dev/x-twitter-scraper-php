<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List tweets posted in a community.
 *
 * @see XTwitterScraper\Services\X\Communities\TweetsService::listByCommunity()
 *
 * @phpstan-type TweetListByCommunityParamsShape = array{
 *   cursor?: string|null, pageSize?: int|null
 * }
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

    /**
     * Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     */
    #[Optional]
    public ?int $pageSize;

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
        ?int $pageSize = null
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;

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

    /**
     * Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }
}
