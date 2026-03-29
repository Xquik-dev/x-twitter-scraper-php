<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionExportResultsParams\Format;

/**
 * Export extraction results.
 *
 * @see XTwitterScraper\Services\ExtractionsService::exportResults()
 *
 * @phpstan-type ExtractionExportResultsParamsShape = array{
 *   format?: null|Format|value-of<Format>
 * }
 */
final class ExtractionExportResultsParams implements BaseModel
{
    /** @use SdkModel<ExtractionExportResultsParamsShape> */
    use SdkModel;
    use SdkParams;

    /** @var value-of<Format>|null $format */
    #[Optional(enum: Format::class)]
    public ?string $format;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Format|value-of<Format>|null $format
     */
    public static function with(Format|string|null $format = null): self
    {
        $self = new self;

        null !== $format && $self['format'] = $format;

        return $self;
    }

    /**
     * @param Format|value-of<Format> $format
     */
    public function withFormat(Format|string $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }
}
