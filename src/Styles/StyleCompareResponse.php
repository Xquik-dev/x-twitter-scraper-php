<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type StyleProfileShape from \XTwitterScraper\Styles\StyleProfile
 *
 * @phpstan-type StyleCompareResponseShape = array{
 *   style1: StyleProfile|StyleProfileShape, style2: StyleProfile|StyleProfileShape
 * }
 */
final class StyleCompareResponse implements BaseModel
{
    /** @use SdkModel<StyleCompareResponseShape> */
    use SdkModel;

    #[Required]
    public StyleProfile $style1;

    #[Required]
    public StyleProfile $style2;

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
     * @param StyleProfile|StyleProfileShape $style1
     * @param StyleProfile|StyleProfileShape $style2
     */
    public static function with(
        StyleProfile|array $style1,
        StyleProfile|array $style2
    ): self {
        $self = new self;

        $self['style1'] = $style1;
        $self['style2'] = $style2;

        return $self;
    }

    /**
     * @param StyleProfile|StyleProfileShape $style1
     */
    public function withStyle1(StyleProfile|array $style1): self
    {
        $self = clone $this;
        $self['style1'] = $style1;

        return $self;
    }

    /**
     * @param StyleProfile|StyleProfileShape $style2
     */
    public function withStyle2(StyleProfile|array $style2): self
    {
        $self = clone $this;
        $self['style2'] = $style2;

        return $self;
    }
}
