<?php

declare(strict_types=1);

namespace XTwitterScraper\Draws;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type DrawDetailShape from \XTwitterScraper\Draws\DrawDetail
 * @phpstan-import-type WinnerShape from \XTwitterScraper\Draws\Winner
 *
 * @phpstan-type DrawGetResponseShape = array{
 *   draw: DrawDetail|DrawDetailShape, winners: list<Winner|WinnerShape>
 * }
 */
final class DrawGetResponse implements BaseModel
{
    /** @use SdkModel<DrawGetResponseShape> */
    use SdkModel;

    #[Required]
    public DrawDetail $draw;

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
     * @param DrawDetail|DrawDetailShape $draw
     * @param list<Winner|WinnerShape> $winners
     */
    public static function with(DrawDetail|array $draw, array $winners): self
    {
        $self = new self;

        $self['draw'] = $draw;
        $self['winners'] = $winners;

        return $self;
    }

    /**
     * @param DrawDetail|DrawDetailShape $draw
     */
    public function withDraw(DrawDetail|array $draw): self
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
