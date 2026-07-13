<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\Tweets\TweetListParams\QueryType;

/**
 * Requires a Community ID and keyword query.
 *
 * @see XTwitterScraper\Services\X\Communities\TweetsService::list()
 *
 * @phpstan-type TweetListParamsShape = array{
 *   communityID: string,
 *   q: string,
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   queryType?: null|QueryType|value-of<QueryType>,
 * }
 */
final class TweetListParams implements BaseModel
{
    /** @use SdkModel<TweetListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Numeric ID of the community to search.
     */
    #[Required]
    public string $communityID;

    /**
     * Keyword query within the selected community.
     */
    #[Required]
    public string $q;

    /**
     * Pagination cursor for community results.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Sort order for community results (Latest or Top).
     *
     * @var value-of<QueryType>|null $queryType
     */
    #[Optional(enum: QueryType::class)]
    public ?string $queryType;

    /**
     * `new TweetListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetListParams::with(communityID: ..., q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetListParams)->withCommunityID(...)->withQ(...)
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
     * @param QueryType|value-of<QueryType>|null $queryType
     */
    public static function with(
        string $communityID,
        string $q,
        ?string $cursor = null,
        ?int $pageSize = null,
        QueryType|string|null $queryType = null,
    ): self {
        $self = new self;

        $self['communityID'] = $communityID;
        $self['q'] = $q;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $pageSize && $self['pageSize'] = $pageSize;
        null !== $queryType && $self['queryType'] = $queryType;

        return $self;
    }

    /**
     * Numeric ID of the community to search.
     */
    public function withCommunityID(string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    /**
     * Keyword query within the selected community.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Pagination cursor for community results.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Maximum items requested from this page (1-100, default 20). The response can contain fewer items because the source returned fewer, filters removed items, or remaining credits cover fewer results. Keep requesting next_cursor while has_next_page is true, even when a page is empty. The deprecated limit and count aliases remain accepted.
     */
    public function withPageSize(int $pageSize): self
    {
        $self = clone $this;
        $self['pageSize'] = $pageSize;

        return $self;
    }

    /**
     * Sort order for community results (Latest or Top).
     *
     * @param QueryType|value-of<QueryType> $queryType
     */
    public function withQueryType(QueryType|string $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

        return $self;
    }
}
