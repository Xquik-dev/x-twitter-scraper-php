<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\Extractions\ExtractionRunParams\Target\UnionMember1;

/**
 * One auto-routed target in a mixed Tweet collection.
 *
 * @phpstan-import-type UnionMember1Shape from \XTwitterScraper\Extractions\ExtractionRunParams\Target\UnionMember1
 *
 * @phpstan-type TargetVariants = string|UnionMember1
 * @phpstan-type TargetShape = TargetVariants|UnionMember1Shape
 */
final class Target implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', UnionMember1::class];
    }
}
