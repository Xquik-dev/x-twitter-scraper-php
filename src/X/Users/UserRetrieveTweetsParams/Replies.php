<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveTweetsParams;

/**
 * Reply mode.
 */
enum Replies: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
