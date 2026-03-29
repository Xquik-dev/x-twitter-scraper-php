<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Search tweets across communities.
 *
 * @see XTwitterScraper\Services\X\CommunitiesService::retrieveSearch()
 *
 * @phpstan-type CommunityRetrieveSearchParamsShape = array{
 *   q: string, cursor?: string|null, queryType?: string|null
 * }
 */
final class CommunityRetrieveSearchParams implements BaseModel
{
    /** @use SdkModel<CommunityRetrieveSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Search query.
     */
    #[Required]
    public string $q;

    /**
     * Pagination cursor.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Sort order (Latest or Top).
     */
    #[Optional]
    public ?string $queryType;

    /**
     * `new CommunityRetrieveSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CommunityRetrieveSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CommunityRetrieveSearchParams)->withQ(...)
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
    public static function with(
        string $q,
        ?string $cursor = null,
        ?string $queryType = null
    ): self {
        $self = new self;

        $self['q'] = $q;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $queryType && $self['queryType'] = $queryType;

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
     * Pagination cursor.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Sort order (Latest or Top).
     */
    public function withQueryType(string $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

        return $self;
    }
}
