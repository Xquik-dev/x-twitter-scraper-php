<?php

declare(strict_types=1);

namespace XTwitterScraper\TweetMedia;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type SizeShape = array{h: int, resize: string, w: int}
 */
final class Size implements BaseModel
{
    /** @use SdkModel<SizeShape> */
    use SdkModel;

    #[Required]
    public int $h;

    #[Required]
    public string $resize;

    #[Required]
    public int $w;

    /**
     * `new Size()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Size::with(h: ..., resize: ..., w: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Size)->withH(...)->withResize(...)->withW(...)
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
    public static function with(int $h, string $resize, int $w): self
    {
        $self = new self;

        $self['h'] = $h;
        $self['resize'] = $resize;
        $self['w'] = $w;

        return $self;
    }

    public function withH(int $h): self
    {
        $self = clone $this;
        $self['h'] = $h;

        return $self;
    }

    public function withResize(string $resize): self
    {
        $self = clone $this;
        $self['resize'] = $resize;

        return $self;
    }

    public function withW(int $w): self
    {
        $self = clone $this;
        $self['w'] = $w;

        return $self;
    }
}
