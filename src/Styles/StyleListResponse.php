<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Styles\StyleListResponse\Style;

/**
 * @phpstan-import-type StyleShape from \XTwitterScraper\Styles\StyleListResponse\Style
 *
 * @phpstan-type StyleListResponseShape = array{styles: list<Style|StyleShape>}
 */
final class StyleListResponse implements BaseModel
{
    /** @use SdkModel<StyleListResponseShape> */
    use SdkModel;

    /** @var list<Style> $styles */
    #[Required(list: Style::class)]
    public array $styles;

    /**
     * `new StyleListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleListResponse::with(styles: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleListResponse)->withStyles(...)
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
     * @param list<Style|StyleShape> $styles
     */
    public static function with(array $styles): self
    {
        $self = new self;

        $self['styles'] = $styles;

        return $self;
    }

    /**
     * @param list<Style|StyleShape> $styles
     */
    public function withStyles(array $styles): self
    {
        $self = clone $this;
        $self['styles'] = $styles;

        return $self;
    }
}
