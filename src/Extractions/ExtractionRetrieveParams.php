<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions;

use XTwitterScraper\Core\Attributes\Optional;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Concerns\SdkParams;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\FieldStyle;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\OutputMode;
use XTwitterScraper\Extractions\ExtractionRetrieveParams\OutputPreset;

/**
 * Get extraction results.
 *
 * @see XTwitterScraper\Services\ExtractionsService::retrieve()
 *
 * @phpstan-type ExtractionRetrieveParamsShape = array{
 *   cursor?: string|null,
 *   fieldStyle?: null|FieldStyle|value-of<FieldStyle>,
 *   includeRaw?: bool|null,
 *   limit?: int|null,
 *   outputMode?: null|OutputMode|value-of<OutputMode>,
 *   outputPreset?: null|OutputPreset|value-of<OutputPreset>,
 * }
 */
final class ExtractionRetrieveParams implements BaseModel
{
    /** @use SdkModel<ExtractionRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Previous nextCursor.
     */
    #[Optional]
    public ?string $cursor;

    /**
     * Preserve source keys or convert result field names.
     *
     * @var value-of<FieldStyle>|null $fieldStyle
     */
    #[Optional(enum: FieldStyle::class)]
    public ?string $fieldStyle;

    /**
     * Use outputMode=raw instead.
     */
    #[Optional]
    public ?bool $includeRaw;

    /**
     * Maximum number of results to return (1-1000, default 100).
     */
    #[Optional]
    public ?int $limit;

    /**
     * Select compact, full, or raw-compatible result fields.
     *
     * @var value-of<OutputMode>|null $outputMode
     */
    #[Optional(enum: OutputMode::class)]
    public ?string $outputMode;

    /**
     * Keep enrichment nested or merge it into each result.
     *
     * @var value-of<OutputPreset>|null $outputPreset
     */
    #[Optional(enum: OutputPreset::class)]
    public ?string $outputPreset;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param FieldStyle|value-of<FieldStyle>|null $fieldStyle
     * @param OutputMode|value-of<OutputMode>|null $outputMode
     * @param OutputPreset|value-of<OutputPreset>|null $outputPreset
     */
    public static function with(
        ?string $cursor = null,
        FieldStyle|string|null $fieldStyle = null,
        ?bool $includeRaw = null,
        ?int $limit = null,
        OutputMode|string|null $outputMode = null,
        OutputPreset|string|null $outputPreset = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $fieldStyle && $self['fieldStyle'] = $fieldStyle;
        null !== $includeRaw && $self['includeRaw'] = $includeRaw;
        null !== $limit && $self['limit'] = $limit;
        null !== $outputMode && $self['outputMode'] = $outputMode;
        null !== $outputPreset && $self['outputPreset'] = $outputPreset;

        return $self;
    }

    /**
     * Previous nextCursor.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    /**
     * Preserve source keys or convert result field names.
     *
     * @param FieldStyle|value-of<FieldStyle> $fieldStyle
     */
    public function withFieldStyle(FieldStyle|string $fieldStyle): self
    {
        $self = clone $this;
        $self['fieldStyle'] = $fieldStyle;

        return $self;
    }

    /**
     * Use outputMode=raw instead.
     */
    public function withIncludeRaw(bool $includeRaw): self
    {
        $self = clone $this;
        $self['includeRaw'] = $includeRaw;

        return $self;
    }

    /**
     * Maximum number of results to return (1-1000, default 100).
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Select compact, full, or raw-compatible result fields.
     *
     * @param OutputMode|value-of<OutputMode> $outputMode
     */
    public function withOutputMode(OutputMode|string $outputMode): self
    {
        $self = clone $this;
        $self['outputMode'] = $outputMode;

        return $self;
    }

    /**
     * Keep enrichment nested or merge it into each result.
     *
     * @param OutputPreset|value-of<OutputPreset> $outputPreset
     */
    public function withOutputPreset(OutputPreset|string $outputPreset): self
    {
        $self = clone $this;
        $self['outputPreset'] = $outputPreset;

        return $self;
    }
}
