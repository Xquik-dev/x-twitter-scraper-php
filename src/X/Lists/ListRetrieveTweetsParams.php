<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Lists;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * List tweets from an X List.
 *
 * @see XTwitterScraper\Services\X\ListsService::retrieveTweets()
 *
 * @phpstan-type ListRetrieveTweetsParamsShape = array{
 *   cursor?: string|null,
 *   includeReplies?: bool|null,
 *   pageSize?: int|null,
 *   sinceTime?: string|null,
 *   untilTime?: string|null,
 * }
 */
final class ListRetrieveTweetsParams implements BaseModel
{
    /** @use SdkModel<ListRetrieveTweetsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Pagination cursor for list tweets.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Include replies (default false).
     */
    #[Optional]
    public ?bool $includeReplies;

    /**
     * Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Unix timestamp - filter after.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * Unix timestamp - filter before.
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
        ?int $pageSize = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $includeReplies && $self['includeReplies'] = $includeReplies;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $untilTime && $self['untilTime'] = $untilTime;

        return $self;
    }

    /**
     * Pagination cursor for list tweets.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Include replies (default false).
     */
    public function withIncludeReplies(bool $includeReplies): self
    {
        $self = clone $this;
        $self['includeReplies'] = $includeReplies;

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

    /**
     * Unix timestamp - filter after.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * Unix timestamp - filter before.
     */
    public function withUntilTime(string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }
}
