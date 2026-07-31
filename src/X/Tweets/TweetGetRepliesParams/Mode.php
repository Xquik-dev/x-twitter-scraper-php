<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesParams;

/**
 * Set complete for maximum-coverage collection. Complete mode accepts only limit. Remove cursor, pageSize, count, time ranges, and tweet filters.
 */
enum Mode: string
{
    case COMPLETE = 'complete';
}
