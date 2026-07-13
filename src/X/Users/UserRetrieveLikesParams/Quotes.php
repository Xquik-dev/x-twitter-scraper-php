<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Users\UserRetrieveLikesParams;

/**
 * Quote mode.
 */
enum Quotes: string
{
    case INCLUDE = 'include';

    case EXCLUDE = 'exclude';

    case ONLY = 'only';
}
