<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesResponse\Diagnostic\StrategiesAttempted;

enum StopReason: string
{
    case DEADLINE = 'deadline';

    case EMPTY_PAGES = 'empty_pages';

    case ERROR = 'error';

    case MISSING_CURSOR = 'missing_cursor';

    case NO_NEXT_PAGE = 'no_next_page';

    case PAGE_CAP = 'page_cap';

    case REPEATED_CURSOR = 'repeated_cursor';
}
