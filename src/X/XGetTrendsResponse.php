<?php

declare(strict_types=1);

namespace XTwitterScraper\X;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\X\XGetTrendsResponse\Trend;

/**
 * @phpstan-import-type TrendShape from \XTwitterScraper\X\XGetTrendsResponse\Trend
 *
 * @phpstan-type XGetTrendsResponseShape = array{
 *   count: int, trends: list<Trend|TrendShape>, woeid: int
 * }
 */
final class XGetTrendsResponse implements BaseModel
{
    /** @use SdkModel<XGetTrendsResponseShape> */
    use SdkModel;

    #[Required]
    public int $count;

    /** @var list<Trend> $trends */
    #[Required(list: Trend::class)]
    public array $trends;

    #[Required]
    public int $woeid;

    /**
     * `new XGetTrendsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * XGetTrendsResponse::with(count: ..., trends: ..., woeid: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new XGetTrendsResponse)->withCount(...)->withTrends(...)->withWoeid(...)
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
    public static function with(int $count, array $trends, int $woeid): self
    {
        $self = new self;

        $self['count'] = $count;
        $self['trends'] = $trends;
        $self['woeid'] = $woeid;

        return $self;
    }

    public function withCount(int $count): self
    {
        $self = clone $this;
        $self['count'] = $count;

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
