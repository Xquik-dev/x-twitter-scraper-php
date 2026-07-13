<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Required;
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
 *   format: Format|value-of<Format>
 * }
 */
final class ExtractionExportResultsParams implements BaseModel
{
    /** @use SdkModel<ExtractionExportResultsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Export file format.
     *
     * @var value-of<Format> $format
     */
    #[Required(enum: Format::class)]
    public string $format;

    /**
     * `new ExtractionExportResultsParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ExtractionExportResultsParams::with(format: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ExtractionExportResultsParams)->withFormat(...)
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
     * @param Format|value-of<Format> $format
     */
    public static function with(Format|string $format): self
    {
        $self = new self;

        $self['format'] = $format;

        return $self;
    }

    /**
     * Export file format.
     *
     * @param Format|value-of<Format> $format
     */
    public function withFormat(Format|string $format): self
    {
        $self = clone $this;
        $self['format'] = $format;

        return $self;
    }
}
