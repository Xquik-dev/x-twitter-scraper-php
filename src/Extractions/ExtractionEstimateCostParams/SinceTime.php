<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;

/**
 * Reply start time as ISO 8601 or Unix seconds.
 *
 * @phpstan-type SinceTimeVariants = int|\DateTimeInterface
 * @phpstan-type SinceTimeShape = SinceTimeVariants
 */
final class SinceTime implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['\DateTimeInterface', 'int'];
    }
}
