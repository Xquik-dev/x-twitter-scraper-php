<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams;

/**
 * Reply depth scope.
 */
enum Scope: string
{
    case ALL = 'all';

    case DIRECT = 'direct';

    case NESTED = 'nested';
}
