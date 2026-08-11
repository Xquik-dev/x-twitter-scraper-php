<?php

declare(strict_types=1);

namespace XTwitterScraper\X\Tweets\TweetSearchResponse\TweetSearchCoverageResponse\Diagnostic\Strategy;

enum QueryType: string
{
    case LATEST = 'Latest';

    case TOP = 'Top';
}
