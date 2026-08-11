<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRetrieveParams;

/**
 * Select compact, full, or raw-compatible result fields.
 */
enum OutputMode: string
{
    case COMPACT = 'compact';

    case FULL = 'full';

    case RAW = 'raw';
}
