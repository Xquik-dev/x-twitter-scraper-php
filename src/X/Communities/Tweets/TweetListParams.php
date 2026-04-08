<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Search tweets across all communities.
 *
 * @see XTwitterScraper\Services\X\Communities\TweetsService::list()
 *
 * @phpstan-type TweetListParamsShape = array{
 *   q: string, cursor?: string|null, queryType?: string|null
 * }
 */
final class TweetListParams implements BaseModel
{
    /** @use SdkModel<TweetListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Search query for cross-community tweets.
     */
    #[Required]
    public string $q;

    /**
     * Pagination cursor for cross-community results.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Sort order for cross-community results (Latest or Top).
     */
    #[Optional]
    public ?string $queryType;

    /**
     * `new TweetListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetListParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetListParams)->withQ(...)
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
     * Search query for cross-community tweets.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Pagination cursor for cross-community results.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Sort order for cross-community results (Latest or Top).
     */
    public function withQueryType(string $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

        return $self;
    }
}
