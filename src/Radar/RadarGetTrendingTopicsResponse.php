<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type RadarItemShape from \XTwitterScraper\Radar\RadarItem
 *
 * @phpstan-type RadarGetTrendingTopicsResponseShape = array{
 *   items: list<RadarItem|RadarItemShape>, total: int
 * }
 */
final class RadarGetTrendingTopicsResponse implements BaseModel
{
    /** @use SdkModel<RadarGetTrendingTopicsResponseShape> */
    use SdkModel;

    /** @var list<RadarItem> $items */
    #[Required(list: RadarItem::class)]
    public array $items;

    #[Required]
    public int $total;

    /**
     * `new RadarGetTrendingTopicsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RadarGetTrendingTopicsResponse::with(items: ..., total: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RadarGetTrendingTopicsResponse)->withItems(...)->withTotal(...)
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
     * @param list<RadarItem|RadarItemShape> $items
     */
    public static function with(array $items, int $total): self
    {
        $self = new self;

        $self['items'] = $items;
        $self['total'] = $total;

        return $self;
    }

    /**
     * @param list<RadarItem|RadarItemShape> $items
     */
    public function withItems(array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
