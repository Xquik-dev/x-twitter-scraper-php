<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Communities\CommunityDeleteResponse\Target;

enum Type: string
{
    case TWEET = 'tweet';

    case USER = 'user';

    case COMMUNITY = 'community';
}
