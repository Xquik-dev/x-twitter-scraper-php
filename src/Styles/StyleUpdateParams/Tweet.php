<?php

declare(strict_types=1);

namespace XTwitterScraper\Styles\StyleUpdateParams;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type TweetShape = array{text: string}
 */
final class Tweet implements BaseModel
{
    /** @use SdkModel<TweetShape> */
    use SdkModel;

    #[Required]
    public string $text;

    /**
     * `new Tweet()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Tweet::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Tweet)->withText(...)
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
    public static function with(string $text): self
    {
        $self = new self;

        $self['text'] = $text;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
