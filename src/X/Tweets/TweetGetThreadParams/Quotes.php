<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetThreadParams;

/**
 * Quote mode.
 */
enum Quotes: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
