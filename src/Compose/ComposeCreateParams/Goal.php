<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeCreateParams;

/**
 * Optimization goal.
 */
enum Goal: string
{
    case ENGAGEMENT = 'engagement';

    case FOLLOWERS = 'followers';

    case AUTHORITY = 'authority';

    case CONVERSATION = 'conversation';
}
