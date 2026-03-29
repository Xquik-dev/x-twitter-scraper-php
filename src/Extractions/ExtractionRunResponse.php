<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionRunResponse\Status;
use XTwitterScraper\Extractions\ExtractionRunResponse\ToolType;

/**
 * @phpstan-type ExtractionRunResponseShape = array{
 *   id: string,
 *   status: Status|value-of<Status>,
 *   toolType: ToolType|value-of<ToolType>,
 * }
 */
final class ExtractionRunResponse implements BaseModel
{
    /** @use SdkModel<ExtractionRunResponseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /** @var value-of<ToolType> $toolType */
    #[Required(enum: ToolType::class)]
    public string $toolType;

    /**
     * `new ExtractionRunResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionRunResponse::with(id: ..., status: ..., toolType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionRunResponse)->withID(...)->withStatus(...)->withToolType(...)
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
     * @param Status|value-of<Status> $status
     * @param ToolType|value-of<ToolType> $toolType
     */
    public static function with(
        string $id,
        Status|string $status,
        ToolType|string $toolType
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['status'] = $status;
        $self['toolType'] = $toolType;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * @param ToolType|value-of<ToolType> $toolType
     */
    public function withToolType(ToolType|string $toolType): self
    {
        $self = clone $this;
        $self['toolType'] = $toolType;

        return $self;
    }
}
