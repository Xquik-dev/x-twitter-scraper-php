<?php

declare(strict_types=1);

namespace XTwitterScraper\Radar;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Radar\RadarGetTrendingTopicsResponse\Item;

/**
 * @phpstan-import-type ItemShape from \XTwitterScraper\Radar\RadarGetTrendingTopicsResponse\Item
 *
 * @phpstan-type RadarGetTrendingTopicsResponseShape = array{
 *   items: list<Item|ItemShape>, total: int
 * }
 */
final class RadarGetTrendingTopicsResponse implements BaseModel
{
    /** @use SdkModel<RadarGetTrendingTopicsResponseShape> */
    use SdkModel;

    /** @var list<Item> $items */
    #[Required(list: Item::class)]
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
     * @param list<Item|ItemShape> $items
     */
    public static function with(array $items, int $total): self
    {
        $self = new self;

        $self['items'] = $items;
        $self['total'] = $total;

        return $self;
    }

    /**
     * @param list<Item|ItemShape> $items
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
