<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Compose;

use XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult;
use XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult;
use XTwitterScraper\Core\Concerns\SdkUnion;
use XTwitterScraper\Core\Conversion\Contracts\Converter;
use XTwitterScraper\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ComposePrepareResultShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult
 * @phpstan-import-type ComposeRefineResultShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposeRefineResult
 * @phpstan-import-type ComposeScoreResultShape from \XTwitterScraper\Compose\ComposeNewResponse\ComposeScoreResult
 *
 * @phpstan-type ComposeNewResponseVariants = ComposePrepareResult|ComposeRefineResult|ComposeScoreResult
 * @phpstan-type ComposeNewResponseShape = ComposeNewResponseVariants|ComposePrepareResultShape|ComposeRefineResultShape|ComposeScoreResultShape
 */
final class ComposeNewResponse implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            ComposePrepareResult::class,
            ComposeRefineResult::class,
            ComposeScoreResult::class,
        ];
    }
}
