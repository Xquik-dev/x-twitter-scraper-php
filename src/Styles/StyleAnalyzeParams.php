<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Analyze writing style from recent tweets.
 *
 * @see XTwitterScraper\Services\StylesService::analyze()
 *
 * @phpstan-type StyleAnalyzeParamsShape = array{username: string}
 */
final class StyleAnalyzeParams implements BaseModel
{
    /** @use SdkModel<StyleAnalyzeParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * X username to analyze.
     */
    #[Required]
    public string $username;

    /**
     * `new StyleAnalyzeParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StyleAnalyzeParams::with(username: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StyleAnalyzeParams)->withUsername(...)
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
    public static function with(string $username): self
    {
        $self = new self;

        $self['username'] = $username;

        return $self;
    }

    /**
     * X username to analyze.
     */
    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
