<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;

/**
 * Reply end time as ISO 8601 or Unix seconds.
 *
 * @phpstan-type UntilTimeVariants = int|\DateTimeInterface
 * @phpstan-type UntilTimeShape = UntilTimeVariants
 */
final class UntilTime implements ConverterSource
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
