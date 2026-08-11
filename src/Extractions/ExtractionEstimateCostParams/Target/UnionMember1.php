<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams\Target;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionEstimateCostParams\Target\UnionMember1\Kind;

/**
 * @phpstan-type UnionMember1Shape = array{
 *   kind: Kind|value-of<Kind>, value: string
 * }
 */
final class UnionMember1 implements BaseModel
{
    /** @use SdkModel<UnionMember1Shape> */
    use SdkModel;

    /** @var value-of<Kind> $kind */
    #[Required(enum: Kind::class)]
    public string $kind;

    #[Required]
    public string $value;

    /**
     * `new UnionMember1()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UnionMember1::with(kind: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UnionMember1)->withKind(...)->withValue(...)
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
     * @param Kind|value-of<Kind> $kind
     */
    public static function with(Kind|string $kind, string $value): self
    {
        $self = new self;

        $self['kind'] = $kind;
        $self['value'] = $value;

        return $self;
    }

    /**
     * @param Kind|value-of<Kind> $kind
     */
    public function withKind(Kind|string $kind): self
    {
        $self = clone $this;
        $self['kind'] = $kind;

        return $self;
    }

    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
