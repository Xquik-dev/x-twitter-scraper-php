<?php

declare(strict_types=1);

namespace XTwitterScraper\TweetMedia;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type FocusRectShape = array{h: int, w: int, x: int, y: int}
 */
final class FocusRect implements BaseModel
{
    /** @use SdkModel<FocusRectShape> */
    use SdkModel;

    #[Required]
    public int $h;

    #[Required]
    public int $w;

    #[Required]
    public int $x;

    #[Required]
    public int $y;

    /**
     * `new FocusRect()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FocusRect::with(h: ..., w: ..., x: ..., y: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FocusRect)->withH(...)->withW(...)->withX(...)->withY(...)
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
    public static function with(int $h, int $w, int $x, int $y): self
    {
        $self = new self;

        $self['h'] = $h;
        $self['w'] = $w;
        $self['x'] = $x;
        $self['y'] = $y;

        return $self;
    }

    public function withH(int $h): self
    {
        $self = clone $this;
        $self['h'] = $h;

        return $self;
    }

    public function withW(int $w): self
    {
        $self = clone $this;
        $self['w'] = $w;

        return $self;
    }

    public function withX(int $x): self
    {
        $self = clone $this;
        $self['x'] = $x;

        return $self;
    }

    public function withY(int $y): self
    {
        $self = clone $this;
        $self['y'] = $y;

        return $self;
    }
}
