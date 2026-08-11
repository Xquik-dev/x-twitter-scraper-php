<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetGetRepliesParams;

/**
 * Sort the selected replies before applying limit.
 */
enum Sort: string
{
    case RELEVANCE = 'relevance';

    case LATEST = 'latest';

    case OLDEST = 'oldest';

    case LIKES = 'likes';
}
