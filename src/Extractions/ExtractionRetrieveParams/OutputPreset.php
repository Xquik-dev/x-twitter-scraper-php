<?php

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
