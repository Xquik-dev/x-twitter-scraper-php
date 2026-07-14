<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveRepliesParams;

/**
 * Retweet mode.
 */
enum Retweets: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
