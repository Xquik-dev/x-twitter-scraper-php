<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetThreadParams;

/**
 * Retweet mode.
 */
enum Retweets: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
