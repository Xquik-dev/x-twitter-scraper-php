<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionRunParams\RelationTarget\Relation;

/**
 * One target and relation in a mixed profile collection.
 *
 * @phpstan-type RelationTargetShape = array{
 *   relation: Relation|value-of<Relation>, value: string
 * }
 */
final class RelationTarget implements BaseModel
{
    /** @use SdkModel<RelationTargetShape> */
    use SdkModel;

    /** @var value-of<Relation> $relation */
    #[Required(enum: Relation::class)]
    public string $relation;

    #[Required]
    public string $value;

    /**
     * `new RelationTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RelationTarget::with(relation: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RelationTarget)->withRelation(...)->withValue(...)
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
     * @param Relation|value-of<Relation> $relation
     */
    public static function with(Relation|string $relation, string $value): self
    {
        $self = new self;

        $self['relation'] = $relation;
        $self['value'] = $value;

        return $self;
    }

    /**
     * @param Relation|value-of<Relation> $relation
     */
    public function withRelation(Relation|string $relation): self
    {
        $self = clone $this;
        $self['relation'] = $relation;

        return $self;
    }

    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
