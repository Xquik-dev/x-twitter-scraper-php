<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Communities\CommunityRetrieveSearchParams\QueryType;

/**
 * Returns tweets, not community records. Requires a Community ID.
 *
 * @see XTwitterScraper\Services\X\CommunitiesService::retrieveSearch()
 *
 * @phpstan-type CommunityRetrieveSearchParamsShape = array{
 *   communityID: string,
 *   q: string,
 *   cursor?: string|null,
 *   pageSize?: int|null,
 *   queryType?: null|QueryType|value-of<QueryType>,
 * }
 */
final class CommunityRetrieveSearchParams implements BaseModel
{
    /** @use SdkModel<CommunityRetrieveSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Numeric ID of the community whose posts to search.
     */
    #[Required]
    public string $communityID;

    /**
     * Search query.
     */
    #[Required]
    public string $q;

    /**
     * Pagination cursor for community search.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Maximum page items (1-100, default 20). Source, filters, or credits can reduce results. Continue while has_next_page is true. Deprecated limit and count aliases remain accepted.
     */
    #[Optional]
    public ?int $pageSize;

    /**
     * Sort order (Latest or Top).
     *
     * @var value-of<QueryType>|null $queryType
     */
    #[Optional(enum: QueryType::class)]
    public ?string $queryType;

    /**
     * `new CommunityRetrieveSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityRetrieveSearchParams::with(communityID: ..., q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityRetrieveSearchParams)->withCommunityID(...)->withQ(...)
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
     * Numeric ID of the community whose posts to search.
     */
    public function withCommunityID(string $communityID): self
    {
        $self = clone $this;
        $self['communityID'] = $communityID;

        return $self;
    }

    /**
     * Search query.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Pagination cursor for community search.
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

    /**
     * Sort order (Latest or Top).
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
