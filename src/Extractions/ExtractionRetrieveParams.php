<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;

/**
 * Get extraction results.
 *
 * @see XTwitterScraper\Services\ExtractionsService::retrieve()
 *
 * @phpstan-type ExtractionRetrieveParamsShape = array{
 *   after?: string|null, limit?: int|null
 * }
 */
final class ExtractionRetrieveParams implements BaseModel
{
    /** @use SdkModel<ExtractionRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Cursor for pagination.
     */
    #[Optional]
    public ?string $after;

    #[Optional]
    public ?int $limit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $after = null, ?int $limit = null): self
    {
        $self = new self;

        null !== $after && $self['after'] = $after;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * Cursor for pagination.
     */
    public function withAfter(string $after): self
    {
        $self = clone $this;
        $self['after'] = $after;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
