<?php

declare(strict_types=1);

namespace XTwitterScraper\SearchTweet\NoteTweet;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * @phpstan-type RichtextTagShape = array{
 *   fromIndex: int, toIndex: int, types: list<string>
 * }
 */
final class RichtextTag implements BaseModel
{
    /** @use SdkModel<RichtextTagShape> */
    use SdkModel;

    #[Required]
    public int $fromIndex;

    #[Required]
    public int $toIndex;

    /** @var list<string> $types */
    #[Required(list: 'string')]
    public array $types;

    /**
     * `new RichtextTag()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RichtextTag::with(fromIndex: ..., toIndex: ..., types: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RichtextTag)->withFromIndex(...)->withToIndex(...)->withTypes(...)
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
     * @param list<string> $types
     */
    public static function with(
        int $fromIndex,
        int $toIndex,
        array $types
    ): self {
        $self = new self;

        $self['fromIndex'] = $fromIndex;
        $self['toIndex'] = $toIndex;
        $self['types'] = $types;

        return $self;
    }

    public function withFromIndex(int $fromIndex): self
    {
        $self = clone $this;
        $self['fromIndex'] = $fromIndex;

        return $self;
    }

    public function withToIndex(int $toIndex): self
    {
        $self = clone $this;
        $self['toIndex'] = $toIndex;

        return $self;
    }

    /**
     * @param list<string> $types
     */
    public function withTypes(array $types): self
    {
        $self = clone $this;
        $self['types'] = $types;

        return $self;
    }
}
