<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Styles\StyleCompareResponse\Style1;
use XTwitterScraper\Styles\StyleCompareResponse\Style2;

/**
 * @phpstan-import-type Style1Shape from \XTwitterScraper\Styles\StyleCompareResponse\Style1
 * @phpstan-import-type Style2Shape from \XTwitterScraper\Styles\StyleCompareResponse\Style2
 *
 * @phpstan-type StyleCompareResponseShape = array{
 *   style1: Style1|Style1Shape, style2: Style2|Style2Shape
 * }
 */
final class StyleCompareResponse implements BaseModel
{
    /** @use SdkModel<StyleCompareResponseShape> */
    use SdkModel;

    #[Required]
    public Style1 $style1;

    #[Required]
    public Style2 $style2;

    /**
     * `new StyleCompareResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleCompareResponse::with(style1: ..., style2: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleCompareResponse)->withStyle1(...)->withStyle2(...)
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
     * @param Style1|Style1Shape $style1
     * @param Style2|Style2Shape $style2
     */
    public static function with(
        Style1|array $style1,
        Style2|array $style2
    ): self {
        $self = new self;

        $self['style1'] = $style1;
        $self['style2'] = $style2;

        return $self;
    }

    /**
     * @param Style1|Style1Shape $style1
     */
    public function withStyle1(Style1|array $style1): self
    {
        $self = clone $this;
        $self['style1'] = $style1;

        return $self;
    }

    /**
     * @param Style2|Style2Shape $style2
     */
    public function withStyle2(Style2|array $style2): self
    {
        $self = clone $this;
        $self['style2'] = $style2;

        return $self;
    }
}
