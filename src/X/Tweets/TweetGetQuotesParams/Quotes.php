<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetQuotesParams;

/**
 * Quote mode.
 */
enum Quotes: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
