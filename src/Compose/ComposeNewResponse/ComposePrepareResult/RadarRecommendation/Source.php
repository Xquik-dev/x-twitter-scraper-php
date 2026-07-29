<?php

declare(strict_types=1);

namespace XTwitterScraper\Compose\ComposeNewResponse\ComposePrepareResult\RadarRecommendation;

enum Source: string
{
    case REDDIT = 'reddit';

    case GITHUB = 'github';

    case TRUSTMRR = 'trustmrr';

    case HACKER_NEWS = 'hacker_news';

    case GOOGLE_TRENDS = 'google_trends';

    case WIKIPEDIA = 'wikipedia';

    case POLYMARKET = 'polymarket';
}
