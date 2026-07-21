<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Profile\ProfileUpdateAvatarResponse\Target;

enum Type: string
{
    case TWEET = 'tweet';

    case USER = 'user';

    case COMMUNITY = 'community';
}
