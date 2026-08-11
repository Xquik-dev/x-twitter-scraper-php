<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionRunParams;

/**
 * Search ranking applied to every query.
 */
enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';

    case BOTH = 'Both';
}
