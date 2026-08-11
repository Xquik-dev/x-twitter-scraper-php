<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesParams;

/**
 * Optional advanced override. Omit mode for automatic maximum direct reply coverage with pagination. Standard keeps legacy pagination. Complete returns direct and nested replies with diagnostics, scope, depth, sorting, and original-post controls.
 */
enum Mode: string
{
    case STANDARD = 'standard';

    case COMPLETE = 'complete';
}
