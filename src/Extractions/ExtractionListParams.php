<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionListParams\Status;
use XTwitterScraper\Extractions\ExtractionListParams\ToolType;

/**
 * List extraction jobs.
 *
 * @see XTwitterScraper\Services\ExtractionsService::list()
 *
 * @phpstan-type ExtractionListParamsShape = array{
 *   after?: string|null,
 *   limit?: int|null,
 *   status?: null|Status|value-of<Status>,
 *   toolType?: null|ToolType|value-of<ToolType>,
 * }
 */
final class ExtractionListParams implements BaseModel
{
    /** @use SdkModel<ExtractionListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Cursor for keyset pagination.
     */
    #[Optional]
    public ?string $after;

    /**
     * Maximum number of items to return (1-100, default 50).
     */
    #[Optional]
    public ?int $limit;

    /**
     * Filter by job status.
     *
     * @var value-of<Status>|null $status
     */
    #[Optional(enum: Status::class)]
    public ?string $status;

    /**
     * Filter by extraction tool type.
     *
     * @var value-of<ToolType>|null $toolType
     */
    #[Optional(enum: ToolType::class)]
    public ?string $toolType;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Status|value-of<Status>|null $status
     * @param ToolType|value-of<ToolType>|null $toolType
     */
    public static function with(
        ?string $after = null,
        ?int $limit = null,
        Status|string|null $status = null,
        ToolType|string|null $toolType = null,
    ): self {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $limit && $self['limit'] = $limit;
        null !== $status && $self['status'] = $status;
        null !== $toolType && $self['toolType'] = $toolType;

        return $self;
    }

    /**
     * Cursor for keyset pagination.
     */
    public function withAfter(string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

        return $self;
    }

    /**
     * Maximum number of items to return (1-100, default 50).
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Filter by job status.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Filter by extraction tool type.
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
