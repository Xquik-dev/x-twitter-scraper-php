<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesParams;

/**
 * Reply mode.
 */
enum Replies: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
