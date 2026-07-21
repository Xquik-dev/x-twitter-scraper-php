<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\Like\LikeDeleteResponse\Target;

enum Type: string
{
    case TWEET = 'tweet';

    case USER = 'user';

    case COMMUNITY = 'community';
}
