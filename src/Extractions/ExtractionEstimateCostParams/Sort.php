<?php

declare(strict_types=1);

namespace XTwitterScraper\Extractions\ExtractionEstimateCostParams;

/**
 * Reply result order.
 */
enum Sort: string
{
    case RELEVANCE = 'relevance';

    case LATEST = 'latest';

    case OLDEST = 'oldest';

    case LIKES = 'likes';
}
