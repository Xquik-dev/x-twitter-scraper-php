<?php

declare(strict_types=1);

namespace XTwitterScraper\Error;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;
use XTwitterScraper\Error\Error\LegacyErrorCode;
use XTwitterScraper\Error\Error\StructuredError;

/**
 * @phpstan-import-type StructuredErrorShape from \XTwitterScraper\Error\Error\StructuredError
 *
 * @phpstan-type ErrorVariants = StructuredError|value-of<LegacyErrorCode>
 * @phpstan-type ErrorShape = ErrorVariants|StructuredErrorShape
 */
final class Error implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [LegacyErrorCode::class, StructuredError::class];
    }
}
