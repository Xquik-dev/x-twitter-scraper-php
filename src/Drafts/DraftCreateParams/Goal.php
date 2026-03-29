<?php

declare(strict_types=1);

namespace XTwitterScraper\Drafts\DraftCreateParams;

enum Goal: string
{
    case ENGAGEMENT = 'engagement';

    case FOLLOWERS = 'followers';

    case AUTHORITY = 'authority';

    case CONVERSATION = 'conversation';
}
