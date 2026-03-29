<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetSearchParams;

/**
 * Sort order — Latest (chronological) or Top (engagement-ranked).
 */
enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';
}
