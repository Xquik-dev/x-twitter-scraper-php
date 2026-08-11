<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRetrieveParams;

/**
 * Keep enrichment nested or merge it into each result.
 */
enum OutputPreset: string
{
    case NESTED = 'nested';

    case FLAT = 'flat';
}
