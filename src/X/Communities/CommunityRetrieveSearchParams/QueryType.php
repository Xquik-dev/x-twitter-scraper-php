<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityRetrieveSearchParams;

/**
 * Sort order (Latest or Top).
 */
enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';
}
