<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Compare two style profiles.
 *
 * @see XTwitterScraper\Services\StylesService::compare()
 *
 * @phpstan-type StyleCompareParamsShape = array{
 *   username1: string, username2: string
 * }
 */
final class StyleCompareParams implements BaseModel
{
    /** @use SdkModel<StyleCompareParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * First username to compare.
     */
    #[Required]
    public string $username1;

    /**
     * Second username to compare.
     */
    #[Required]
    public string $username2;

    /**
     * `new StyleCompareParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleCompareParams::with(username1: ..., username2: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleCompareParams)->withUsername1(...)->withUsername2(...)
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
    public static function with(string $username1, string $username2): self
    {
        $self = new self;

        $self['username1'] = $username1;
        $self['username2'] = $username2;

        return $self;
    }

    /**
     * First username to compare.
     */
    public function withUsername1(string $username1): self
    {
        $self = clone $this;
        $self['username1'] = $username1;

        return $self;
    }

    /**
     * Second username to compare.
     */
    public function withUsername2(string $username2): self
    {
        $self = clone $this;
        $self['username2'] = $username2;

        return $self;
    }
}
