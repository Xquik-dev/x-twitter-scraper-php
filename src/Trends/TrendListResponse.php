<?php

declare(strict_types=1);

namespace XTwitterScraper\Trends;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Trends\TrendListResponse\Trend;

/**
 * @phpstan-import-type TrendShape from \XTwitterScraper\Trends\TrendListResponse\Trend
 *
 * @phpstan-type TrendListResponseShape = array{
 *   total: int, trends: list<Trend|TrendShape>, woeid: int
 * }
 */
final class TrendListResponse implements BaseModel
{
    /** @use SdkModel<TrendListResponseShape> */
    use SdkModel;

    #[Required]
    public int $total;

    /** @var list<Trend> $trends */
    #[Required(list: Trend::class)]
    public array $trends;

    #[Required]
    public int $woeid;

    /**
     * `new TrendListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TrendListResponse::with(total: ..., trends: ..., woeid: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TrendListResponse)->withTotal(...)->withTrends(...)->withWoeid(...)
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
     * @param list<Trend|TrendShape> $trends
     */
    public static function with(int $total, array $trends, int $woeid): self
    {
        $self = new self;

        $self['total'] = $total;
        $self['trends'] = $trends;
        $self['woeid'] = $woeid;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    /**
     * @param list<Trend|TrendShape> $trends
     */
    public function withTrends(array $trends): self
    {
        $self = clone $this;
        $self['trends'] = $trends;

        return $self;
    }

    public function withWoeid(int $woeid): self
    {
        $self = clone $this;
        $self['woeid'] = $woeid;

        return $self;
    }
}
