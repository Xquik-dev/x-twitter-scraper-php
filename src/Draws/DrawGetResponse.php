<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Draws\DrawGetResponse\Draw;
use XTwitterScraper\Draws\DrawGetResponse\Winner;

/**
 * @phpstan-import-type DrawShape from \XTwitterScraper\Draws\DrawGetResponse\Draw
 * @phpstan-import-type WinnerShape from \XTwitterScraper\Draws\DrawGetResponse\Winner
 *
 * @phpstan-type DrawGetResponseShape = array{
 *   draw: Draw|DrawShape,
 *   winners: list<\XTwitterScraper\Draws\DrawGetResponse\Winner|WinnerShape>,
 * }
 */
final class DrawGetResponse implements BaseModel
{
    /** @use SdkModel<DrawGetResponseShape> */
    use SdkModel;

    /**
     * Full giveaway draw with tweet metrics, entries, and timing.
     */
    #[Required]
    public Draw $draw;

    /** @var list<Winner> $winners */
    #[Required(list: Winner::class)]
    public array $winners;

    /**
     * `new DrawGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DrawGetResponse::with(draw: ..., winners: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DrawGetResponse)->withDraw(...)->withWinners(...)
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
     * @param Draw|DrawShape $draw
     * @param list<Winner|WinnerShape> $winners
     */
    public static function with(Draw|array $draw, array $winners): self
    {
        $self = new self;

        $self['draw'] = $draw;
        $self['winners'] = $winners;

        return $self;
    }

    /**
     * Full giveaway draw with tweet metrics, entries, and timing.
     *
     * @param Draw|DrawShape $draw
     */
    public function withDraw(Draw|array $draw): self
    {
        $self = clone $this;
        $self['draw'] = $draw;

        return $self;
    }

    /**
     * @param list<Winner|WinnerShape> $winners
     */
    public function withWinners(array $winners): self
    {
        $self = clone $this;
        $self['winners'] = $winners;

        return $self;
    }
}
