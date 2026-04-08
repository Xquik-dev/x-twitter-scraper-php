<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionListResponse;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionListResponse\Extraction\Status;
use XTwitterScraper\Extractions\ExtractionListResponse\Extraction\ToolType;

/**
 * Extraction job tracking status, tool type, and result count.
 *
 * @phpstan-type ExtractionShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   status: Status|value-of<Status>,
 *   toolType: ToolType|value-of<ToolType>,
 *   totalResults: int,
 *   completedAt?: \DateTimeInterface|null,
 * }
 */
final class Extraction implements BaseModel
{
    /** @use SdkModel<ExtractionShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Identifier for the extraction tool used to run a job.
     *
     * @var value-of<ToolType> $toolType
     */
    #[Required(enum: ToolType::class)]
    public string $toolType;

    #[Required]
    public int $totalResults;

    #[Optional]
    public ?\DateTimeInterface $completedAt;

    /**
     * `new Extraction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Extraction::with(
     *   id: ..., createdAt: ..., status: ..., toolType: ..., totalResults: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Extraction)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withStatus(...)
     *   ->withToolType(...)
     *   ->withTotalResults(...)
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
        \DateTimeInterface $createdAt,
        Status|string $status,
        ToolType|string $toolType,
        int $totalResults,
        ?\DateTimeInterface $completedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['status'] = $status;
        $self['toolType'] = $toolType;
        $self['totalResults'] = $totalResults;

        null !== $completedAt && $self['completedAt'] = $completedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

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

    public function withTotalResults(int $totalResults): self
    {
        $self = clone $this;
        $self['totalResults'] = $totalResults;

        return $self;
    }

    public function withCompletedAt(\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }
}
