<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionRunResponse\ToolType;

/**
 * @phpstan-type ExtractionRunResponseShape = array{
 *   id: string, status: 'running', toolType: ToolType|value-of<ToolType>
 * }
 */
final class ExtractionRunResponse implements BaseModel
{
    /** @use SdkModel<ExtractionRunResponseShape> */
    use SdkModel;

    /** @var 'running' $status */
    #[Required]
    public string $status = 'running';

    #[Required]
    public string $id;

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @var value-of<ToolType> $toolType
     */
    #[Required(enum: ToolType::class)]
    public string $toolType;

    /**
     * `new ExtractionRunResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionRunResponse::with(id: ..., toolType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionRunResponse)->withID(...)->withToolType(...)
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
     * @param ToolType|value-of<ToolType> $toolType
     */
    public static function with(string $id, ToolType|string $toolType): self
    {
        $self = new self;

        $self['id'] = $id;
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
     * @param 'running' $status
     */
    public function withStatus(string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @param ToolType|value-of<ToolType> $toolType
     */
    public function withToolType(ToolType|string $toolType): self
    {
        $self = clone $this;
        $self['toolType'] = $toolType;

        return $self;
    }
}
