<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams;

/**
 * Keep target duplicates, first rows, or merged overlap.
 */
enum DedupeMode: string
{
    case NONE = 'none';

    case FIRST = 'first';

    case MERGE = 'merge';
}
