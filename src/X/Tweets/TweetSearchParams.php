<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\Tweets\TweetSearchParams\QueryType;

/**
 * Search tweets.
 *
 * @see XTwitterScraper\Services\X\TweetsService::search()
 *
 * @phpstan-type TweetSearchParamsShape = array{
 *   q: string,
 *   cursor?: string|null,
 *   limit?: int|null,
 *   queryType?: null|QueryType|value-of<QueryType>,
 *   sinceTime?: string|null,
 *   untilTime?: string|null,
 * }
 */
final class TweetSearchParams implements BaseModel
{
    /** @use SdkModel<TweetSearchParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Search query (keywords,.
     */
    #[Required]
    public string $q;

    /**
     * Pagination cursor from previous response.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Max tweets to return (server paginates internally). Omit for single page (~20).
     */
    #[Optional]
    public ?int $limit;

    /**
     * Sort order — Latest (chronological) or Top (engagement-ranked).
     *
     * @var value-of<QueryType>|null $queryType
     */
    #[Optional(enum: QueryType::class)]
    public ?string $queryType;

    /**
     * ISO 8601 timestamp — only return tweets after this time.
     */
    #[Optional]
    public ?string $sinceTime;

    /**
     * ISO 8601 timestamp — only return tweets before this time.
     */
    #[Optional]
    public ?string $untilTime;

    /**
     * `new TweetSearchParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TweetSearchParams::with(q: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TweetSearchParams)->withQ(...)
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
        string $q,
        ?string $cursor = null,
        ?int $limit = null,
        QueryType|string|null $queryType = null,
        ?string $sinceTime = null,
        ?string $untilTime = null,
    ): self {
        $self = new self;

        $self['q'] = $q;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $queryType && $self['queryType'] = $queryType;
        null !== $sinceTime && $self['sinceTime'] = $sinceTime;
        null !== $untilTime && $self['untilTime'] = $untilTime;

        return $self;
    }

    /**
     * Search query (keywords,.
     */
    public function withQ(string $q): self
    {
        $self = clone $this;
        $self['q'] = $q;

        return $self;
    }

    /**
     * Pagination cursor from previous response.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Max tweets to return (server paginates internally). Omit for single page (~20).
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Sort order — Latest (chronological) or Top (engagement-ranked).
     *
     * @param QueryType|value-of<QueryType> $queryType
     */
    public function withQueryType(QueryType|string $queryType): self
    {
        $self = clone $this;
        $self['queryType'] = $queryType;

        return $self;
    }

    /**
     * ISO 8601 timestamp — only return tweets after this time.
     */
    public function withSinceTime(string $sinceTime): self
    {
        $self = clone $this;
        $self['sinceTime'] = $sinceTime;

        return $self;
    }

    /**
     * ISO 8601 timestamp — only return tweets before this time.
     */
    public function withUntilTime(string $untilTime): self
    {
        $self = clone $this;
        $self['untilTime'] = $untilTime;

        return $self;
    }
}
