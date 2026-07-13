<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveMentionsParams;

/**
 * Retweet mode.
 */
enum Retweets: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
